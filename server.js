import express from "express";
const app = express();
import parser from "liqe";
const PORT = 8081;

app.use(express.static('openapi'));

app.get('/', (req, res) => {
    res.send('Hello IODA!');
});

app.get('/parse', (req, res) => {
    let query = req.query
    // query = query.q.slice(0, -1).replace(/\r?\n|\r/g, "")
    let out = parser.parse(query.q)
    res.send(out)
});

app.listen(PORT, () => console.log(`Server listening on port: ${PORT}`));