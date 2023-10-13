import app from "./app"

const host = "http://localhost"
const port = process.env?.PORT || 8081

app.listen(port, () => {
    /* eslint-disable no-console */
    console.log(`Listening: ${host}:${port}`)
    /* eslint-enable no-console */
})