import {AssetsRequestBody, Filetree} from "./interfaces";
import {readFileSync} from "fs";

export const ENTRYPOINT = "types"

export const isValidRequest = (req: any): req is AssetsRequestBody => {
    let reqSize = Array.of(req).length
    return (
        reqSize > 0 &&
        reqSize < 4 &&
        req.type &&
        req.file)
}

export const getFileTree = (path: string): Filetree => {
    let tree: { [ENTRYPOINT]: Filetree }
    let treeFile = readFileSync(path, {encoding: 'utf8'})
    tree = JSON.parse(treeFile)
    if (!tree[ENTRYPOINT])
        throw new Error('Invalid file')
    return tree[ENTRYPOINT]
}

export const createTreeView = (path: string): Object => {
    let tree = getFileTree(path)
    let returns = new Map<string, Array<string>>
    for (let [type, desc] of Object.entries(tree)) {
        let l: Array<string> = []
        if (desc.isBucket)
            for (let bucket in desc.buckets)
                l.push(bucket)
        returns.set(`${type}${desc.isBucket ? ' <span>(bucket)</span>' : ''}`, l)
    }
    return Object.fromEntries(returns.entries())
}