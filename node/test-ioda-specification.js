import OpenAPIParser from "@readme/openapi-parser";

(async () => {
    try {
        await OpenAPIParser.validate('./openapi/index.yaml', {
            validate: {
                colorizeErrors: true,
            }
        });
        console.info("Validation complete!")
    } catch (err) {
        console.error(err.message);
    }
})();