import express from "express";
const app = express();
const PORT = 8081;

app.use(express.static('openapi'));

app.get('/', (req, res) => {
    res.send('Hello IODA!');
});

app.listen(PORT, () => console.log(`Server listening on port: ${PORT}`));