export interface AssetsRequestBody {
    type: string,
    bucket?: string,
    file: string
}

export interface AssetsNode {
    isBucket?: boolean,
    path: string,
    type?: string,
    buckets: { [e: string]: AssetsNode }
}

export type Filetree = { [e: string]: AssetsNode }