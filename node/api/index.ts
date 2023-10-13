import express from "express"

import parsers from "./parsers"

const router = express.Router()

router.use("/parse", parsers)

export default router