Centauri.Utility.ImageUtility = {
    addImage: (identifier, image) => {
        if(Centauri.isUndefined(Centauri.Utility.ImageUtility.loadedImages[identifier])) {
            Centauri.Utility.ImageUtility.loadedImages[identifier] = true;

            Centauri.Utility.ImageUtility.images.push({
                identifier: identifier,
                image: image
            });

            return true;
        }

        return false;
    },

    findImageByIdentifier: (identifier) => {
        if(Centauri.isNotUndefined(Centauri.Utility.ImageUtility.loadedImages[identifier])) {
            return Centauri.Utility.ImageUtility.loadedImages[identifier];
        }

        return null;
    },

    preloadCachedImages: () => {
        let _images = [];
        let images = Centauri.Utility.ImageUtility.images;

        $.each(images, (index, item) => {
            let imgSelector = "img[data-src='" + item.identifier + "']";

            if(Centauri.elExists($(imgSelector))) {
                let $img = $(imgSelector);
                $img.parent().removeClass("placeholder");

                $(item.image).insertAfter($img);
                $img.remove();
            }

            _images.push({
                identifier: item.identifier,
                image: item.image
            });
        });

        Centauri.Utility.ImageUtility.images = _images;
    }
};

Centauri.Utility.ImageUtility.images = [];
Centauri.Utility.ImageUtility.loadedImages = [];
