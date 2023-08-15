import express from "express";
const app = express();
import parser from "liqe";
const PORT = 8081;

app.use(express.static('openapi'));

app.get('/', (req, res) => {
    res.send('Hello Console!');
});

app.get('/parse', (req, res) => {
    let query = req.query
    let out = parser.parse(query.q)
    res.send(out)
});

app.listen(PORT, () => console.log(`Server listening on port: ${PORT}`));