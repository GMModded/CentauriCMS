const childProcess = require("child_process");

class GulpfileHelper
{
    moduleExists = (name) => {
        try {
            let exists = require.resolve(name);
            return true;
        } catch(e) {
            return false;
        }
    }
}

module.exports = GulpfileHelper;
