import express, {Application, Request, Response} from "express"
import * as middlewares from "./middlewares"
import api from "./api"
import {aggAward} from "./utils/data"

const app: Application = express();

app.use(express.json())
app.use(express.static('openapi'));

app.post('/run', (req: Request, res: Response) => {
    let fn: { [source: string]: any } = {}
    const {fn: fn1} = req.body;
    if (fn1 !== "aggAward") {
    } else {
        fn = aggAward(req.body.input)
    }
    let out = fn
    res.send(out)
});

app.use("/api/v1", api)

app.use(middlewares.notFound)
app.use(middlewares.errorHandler)

export default app