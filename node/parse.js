var parser = require("liqe");
let query = process.argv[2].slice(0, -1).replace(/\r?\n|\r/g, "")
let out = JSON.stringify(parser.parse(query))
console.log(out)