var parser = require("liqe");
let query = process.argv[2].slice(0, -1).replace(/\r?\n|\r/g, "")
// console.log(parser.parse(query))
console.log("out")
// query = "doe AND 1212 AND !foo"
let out = JSON.stringify(parser.parse(query))
console.log(out)