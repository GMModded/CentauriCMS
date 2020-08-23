Centauri.Utility.ContentUtility = {
    addCachedContent: (identifier, content) => {
        if(Centauri.isUndefined(Centauri.Utility.ContentUtility.contents[identifier])) {
            Centauri.Utility.ContentUtility.contents.push({
                identifier: identifier,
                content: content
            });

            return true;
        }

        return false;
    },

    getCachedContentByIdentifier: (identifier) => {
        return "";
        let cached = false;

        $(Centauri.Utility.ContentUtility.contents).each(function(index, item) {
            if(item.identifier == identifier) {
                cached = item;
            }
        });

        /**
         * @todo cached image content fix
         */

        if(!cached) {
            return "";
        }

        return cached.content;
    },

    loadCachedContent: (identifier) => {
        document.getElementById("content").innerHTML = Centauri.Utility.ContentUtility.getCachedContentByIdentifier(identifier);
    }
};

Centauri.Utility.ContentUtility.contents = [];
