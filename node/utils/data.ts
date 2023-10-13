export const justTheHits = (args: string) => {
    let result = JSON.parse(args)
    return result?.data?.hits?.hits[0]?._source || undefined
}

export const aggAward = (args: string) => {
    const eod: string = "0000-01-01"
    const result = justTheHits(args)
    let out = {}
    if (result) {


        out = result
    }
    return out
}
