import express, {Request, Response} from "express"
import {parse} from "liqe"

const router = express.Router()

router.get('/lucene', (req: Request, res: Response) => {
    let query = req.query
    let out = parse(query.q.toString())
    res.send(out)
});

export default router