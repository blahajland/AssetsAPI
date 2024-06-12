import express from 'express';
import {createTreeView, getFileTree, isValidRequest} from "./tools";
import {AssetsNode, AssetsRequestBody, Filetree} from "./interfaces";
import * as fs from "node:fs";
import {existsSync} from "node:fs";
import path from "node:path";
import compression from "compression"

export const FALLBACK = "_fallback"
export const FILETREE = '/../json/filetree.json'

const app = express();
const port = 3000;

app.use(compression())

app.set('view engine', 'pug')
app.set('views', path.join(__dirname, '/views'));

app.post('/', (req, res) => {
    res.send('What the fuck')
})


app.get('/', (req, res) => {
    res.render('index', {
        ascii_icon: fs.readFileSync(`${__dirname}/../ascii/blahaj.txt`, {encoding: "utf-8"}),
        ascii_title: fs.readFileSync(`${__dirname}/../ascii/title.txt`, {encoding: 'utf-8'}),
        treeview: createTreeView(__dirname + FILETREE)
    })
})

app.post('/api/', (req, res) => {
    res.status(400).json(`This API doesn't support POST`)
})

app.get('/api/', (req, res) => {
    res.setHeader('Access-Control-Allow-Origin', '*')
    if (!req.query || !isValidRequest(req.query))
        return res.status(401).json('Invalid parameters')
    let requestQuery = req.query as any as AssetsRequestBody
    let fileTree: Filetree = getFileTree(__dirname + FILETREE)
    let currentNode: AssetsNode
    if (!(requestQuery.type in fileTree))
        return res.status(401).json('Invalid type')
    currentNode = fileTree[requestQuery.type]
    let filePath = `${__dirname}/../${currentNode.path}`
    if (currentNode.isBucket) {
        if (!(requestQuery.bucket && requestQuery.bucket in currentNode.buckets))
            return res.status(401).json('Invalid bucket')
        currentNode = currentNode.buckets[requestQuery.bucket]
        filePath += currentNode.path
    }
    let finalFilePath = `${filePath}${requestQuery.file}${currentNode.type}`
    res.sendFile(path.resolve(existsSync(finalFilePath) ? finalFilePath : `${filePath}${FALLBACK}${currentNode.type ??= ''}`))
});

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});