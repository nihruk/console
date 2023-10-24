export const justTheHits = (args: string) => {
    let result = JSON.parse(args)
    return result?.data?.hits?.hits
}

export const aggAward = (args: string) => {
    const hits = justTheHits(args)
    return hits[0]?._source || {}
}
