$(document).ready(function() {
    if (window.File && window.FileList && window.FileReader) {
        $("#files").on("change", function(e) {

            $(this).parent(".file_zone").children('.pip').remove();

            let files = e.target.files,
                filesLength = files.length;

            for (let i = 0; i < filesLength; i++) {
                let f = files[i]
                let fileReader = new FileReader();
                fileReader.onload = (function(e) {
                    let file = e.target;
                    $("<span class=\"pip\">" +
                        "<img alt='product image' class=\"imageThumb\" src=\"" + file.result + "\" title=\"" + file.name + "\" />"
                    ).insertAfter("#files");
                });
                fileReader.readAsDataURL(f);
            }
        });
    } else {
        alert("Your browser doesn't support File API")
    }
});
