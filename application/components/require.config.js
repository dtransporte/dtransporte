var components = {
    "packages": [
        {
            "name": "jquery",
            "main": "jquery-built.js"
        },
        {
            "name": "jquery-ui",
            "main": "jquery-ui-built.js"
        },
        {
            "name": "bootstrap-datetimepicker",
            "main": "bootstrap-datetimepicker-built.js"
        },
        {
            "name": "moment",
            "main": "moment-built.js"
        }
    ],
    "shim": {
        "jquery-ui": {
            "deps": [
                "jquery"
            ],
            "exports": "jQuery"
        },
        "popper.js": {
            "deps": [
                "jquery"
            ]
        }
    },
    "baseUrl": "components"
};
if (typeof require !== "undefined" && require.config) {
    require.config(components);
} else {
    var require = components;
}
if (typeof exports !== "undefined" && typeof module !== "undefined") {
    module.exports = components;
}