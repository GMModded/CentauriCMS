Centauri.Utility.ImageUtility = {
    addImage: (identifier, image) => {
        Centauri.Utility.ImageUtility.loadedImages[identifier] = true;

        Centauri.Utility.ImageUtility.images.push({
            identifier: identifier,
            image: image
        });
    },

    findImageByIdentifier: (identifier) => {
        if(Centauri.isNotUndefined(Centauri.Utility.ImageUtility.loadedImages[identifier])) {
            return Centauri.Utility.ImageUtility.loadedImages[identifier];
        }

        return null;
    },

    preloadCachedImages: () => {
        let images = Centauri.Utility.ImageUtility.images;

        $.each(images, (index, item) => {
            let $img = $("img[data-src='" + item.identifier + "']");
            $img.parent().removeClass("placeholder");

            $("<img class='img-fluid w-100' />").attr("src", item.image.src).insertAfter($img);
            $img.remove();

            // $img.attr("src", item.image.src);
            // $img.removeAttr("data-src");
        });
    }
};

Centauri.Utility.ImageUtility.images = [];
Centauri.Utility.ImageUtility.loadedImages = [];
