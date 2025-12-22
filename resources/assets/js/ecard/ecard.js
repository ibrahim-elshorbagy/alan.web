// document.addEventListener("turbo:load", loadEcardData);
document.addEventListener("DOMContentLoaded", loadEcardData);
function loadEcardData() {
    $("#e-vcard-id").select2({
        placeholder: Lang.get("js.select_vcard"),
    });
    $("#custom-e-vcard-id").select2({
        placeholder: Lang.get("js.select_vcard"),
    });
    $("#vcard_size").select2({
        placeholder: Lang.get("js.select_vcard"),
    });
    resetCardFrom()
}
listenChange("#e-vcard-id", function (e) {
    e.preventDefault();
    let vcardId = $("#e-vcard-id").val();
    if (!vcardId) {
        return;
    }
    $.ajax({
        url: route("get-vcard-data"),
        type: "GET",
        data: { vcardId: vcardId },
        success: function (result) {
            if (result.success) {
                $("#e-card-first-name").val(result.data.first_name);
                $("#e-card-last-name").val(result.data.last_name);
                $("#e-card-email").val(result.data.email);
                $("#e-card-occupation").val(result.data.occupation);
                $("#e-card-location").val(result.data.location);
                $("#prefix_code").val(result.data.region_code);
                $("#phoneNumber").val(result.data.phone);
                $("#e-card-website").val(result.data.website);
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
});
function resetCardFrom() {
    $('#virtualBackgroundSubmitBtn').on('click', function (event) {
        event.preventDefault(); // Prevent default form submission
        document.e_card_form.submit();
        // Reset the form after a short delay to ensure the submission is processed
        setTimeout(function () {
            document.e_card_form.reset();
            $('#e-vcard-id').val('').trigger('change');
        }, 1000);
    });
}

$(document).ready(function () {
    if ($("#frontCanvas").length && $("#backCanvas").length) {
        var frontcanvas = new fabric.Canvas("frontCanvas");
        var backcanvas = new fabric.Canvas("backCanvas");

        // Set default white background
        frontcanvas.setBackgroundColor(
            "white",
            frontcanvas.renderAll.bind(frontcanvas)
        );
        backcanvas.setBackgroundColor(
            "white",
            backcanvas.renderAll.bind(backcanvas)
        );

        fabric.Image.fromURL(defaultPlaceholderImgUrl, function (img) {
            frontcanvas.setBackgroundImage(img, frontcanvas.renderAll.bind(frontcanvas), {
                scaleX: frontcanvas.width / img.width,
                scaleY: frontcanvas.height / img.height
            });
        });

        fabric.Image.fromURL(defaultPlaceholderImgUrl, function (img) {
            backcanvas.setBackgroundImage(img, backcanvas.renderAll.bind(backcanvas), {
                scaleX: backcanvas.width / img.width,
                scaleY: backcanvas.height / img.height
            });
        });
    }

    function setCanvasBackgroundImage(canvas, imgUrl) {
        fabric.Image.fromURL(imgUrl, function (img) {
            // Calculate the scale to preserve aspect ratio
            const canvasAspect = canvas.width / canvas.height;
            const imgAspect = img.width / img.height;

            let scaleX, scaleY;
            if (canvasAspect > imgAspect) {
                // Fit to height
                scaleY = canvas.height / img.height;
                scaleX = scaleY;
            } else {
                // Fit to width
                scaleX = canvas.width / img.width;
                scaleY = scaleX;
            }

            // Center the image vertically and horizontally
            const xOffset = (canvas.width - img.width * scaleX) / 2;
            const yOffset = (canvas.height - img.height * scaleY) / 2;

            canvas.setBackgroundImage(
                img,
                canvas.renderAll.bind(canvas),
                {
                    scaleX: scaleX,
                    scaleY: scaleY,
                    top: yOffset,
                    left: xOffset,
                    originX: "left",
                    originY: "top"
                }
            );
        });
    }
    $("#vcard_size").on("change", function (e) {
        let vcardSize = $(this).val();
        let selectedValue = vcardSize;
        $("#custom-e-card-form")[0].reset();
        $(
            "#custom-e-card-logo",
            "#e-card-front-image",
            "#e-card-back-image"
        ).val("");
        $("#exampleInputImage").css(
            "background-image",
            'url("/assets/img/placeholder.png")'
        );
        $("#forntImage").css(
            "background-image",
            'url("/assets/img/placeholder.png")'
        );
        $("#backInputImage").css(
            "background-image",
            'url("/assets/img/placeholder.png")'
        );
        $(this).val(selectedValue);
        $("#custom-e-vcard-id").val("").trigger("change");
        frontcanvas.clear();
        backcanvas.clear();
        let canvasWidth = parseInt(vcardSize) === 1 ? 500 : 300;
        let canvasHeight = parseInt(vcardSize) === 1 ? 300 : 500;
        $("#frontCanvas, #backCanvas")
            .attr("width", canvasWidth)
            .attr("height", canvasHeight);
        $("#frontCanvasContainer, #backCanvasContainer").css({
            width: canvasWidth + "px",
            height: canvasHeight + "px",
        });
        $("#frontCanvasContainer, #backCanvasContainer")
            .find(".canvas-container")
            .css({ width: canvasWidth + "px", height: canvasHeight + "px" });
        $("#frontCanvasContainer, #backCanvasContainer")
            .find(".lower-canvas")
            .css({ width: canvasWidth + "px", height: canvasHeight + "px" });
        $("#frontCanvasContainer, #backCanvasContainer")
            .find(".upper-canvas")
            .css({ width: canvasWidth + "px", height: canvasHeight + "px" });

        frontcanvas.setDimensions({ width: canvasWidth, height: canvasHeight });
        backcanvas.setDimensions({ width: canvasWidth, height: canvasHeight });

        // Set default white background
        frontcanvas.setBackgroundColor(
            "white",
            frontcanvas.renderAll.bind(frontcanvas)
        );
        backcanvas.setBackgroundColor(
            "white",
            backcanvas.renderAll.bind(backcanvas)
        );

        setCanvasBackgroundImage(frontcanvas, defaultPlaceholderImgUrl);

        setCanvasBackgroundImage(backcanvas, defaultPlaceholderImgUrl);
    });

    function isObjectWithIdExists(canvas, id) {
        let isExists = null;
        canvas.forEachObject(function (obj) {
            if (obj.id === id) {
                isExists = obj;
                return;
            }
        });
        return isExists;
    }

    //     const canvas = new fabric.Canvas("canvas");
    let logoImage;

    function loadImageToCanvas(input, canvas, bg = false) {
        let file = input.files[0];
        let reader = new FileReader();
        reader.onload = function (event) {
            let imgObj = new Image();
            imgObj.src = event.target.result;
            imgObj.onload = function () {
                if (input.id === "custom-e-card-logo") {
                    if (imgObj.width > 150 || imgObj.height > 150) {
                        if (logoImage) {
                            canvas.remove(logoImage);
                            logoImage = null;
                        }
                        displayErrorMessage(Lang.get("js.logo_image_error"));
                        $("#custom-e-card-logo").val("");
                        $("#exampleInputImage").css(
                            "background-image",
                            'url("/web/media/logos/infyom.png")'
                        );

                        return false;
                    }
                    if (logoImage) {
                        canvas.remove(logoImage);
                    }
                    const boundingBoxWidth = 150;
                    const boundingBoxHeight = 150;

                    // Calculate scale factors
                    const scaleX = boundingBoxWidth / imgObj.width;
                    const scaleY = boundingBoxHeight / imgObj.height;
                    const scale = Math.max(scaleX, scaleY);

                    // Calculate scaled dimensions
                    const scaledWidth = imgObj.width * scale;
                    const scaledHeight = imgObj.height * scale;

                    // Center the image
                    logoImage = new fabric.Image(imgObj, {
                        scaleX: scale,
                        scaleY: scale,
                        top: (canvas.height - scaledHeight) / 2,
                        left: (canvas.width - scaledWidth) / 2,
                        selectable: true,
                    });
                    canvas.add(logoImage);
                } else {
                    if (bg) {
                        canvas.setBackgroundImage(
                            imgObj.src,
                            canvas.renderAll.bind(canvas),
                            {
                                scaleX: canvas.width / imgObj.width,
                                scaleY: canvas.height / imgObj.height,
                            }
                        );
                    } else {
                        const fabricImg = new fabric.Image(imgObj, {
                            top: canvas.height / 2 - 50,
                            left: canvas.width / 2 - 50,
                            selectable: true,
                            scaleX: 0.5,
                            scaleY: 0.5,
                        });
                        canvas.add(fabricImg);
                    }
                }
                canvas.renderAll();
            };
        };
        reader.readAsDataURL(file);
    }

    function addSvgIcon(canvas, svgPath, left, top, scale = 1, id = null) {
        fabric.loadSVGFromString(svgPath, function (objects, options) {
            var svgObject = fabric.util.groupSVGElements(objects, options);
            svgObject.set({
                id: id,
                left: left,
                top: top,
                scaleX: scale,
                scaleY: scale,
            });
            canvas.add(svgObject);
            canvas.renderAll();
        });
        return;
    }

    listenChange("#custom-e-card-logo", function () {
        loadImageToCanvas(this, backcanvas, false);
    });

    listenChange("#e-card-front-image", function () {
        loadImageToCanvas(this, frontcanvas, true);
    });

    listenChange("#e-card-back-image", function () {
        loadImageToCanvas(this, backcanvas, true);
    });

    listenChange("#custom-e-vcard-id", function (e) {
        e.preventDefault();
        let vcardId = $("#custom-e-vcard-id").val();

        if (vcardId !== "") {
            $.ajax({
                url: route("get-vcard-data"),
                type: "GET",
                data: { vcardId: vcardId },
                success: function (result) {
                    if (result.success) {
                        $("#custom-card-first-name").val(
                            result.data.first_name
                        );
                        $("#custom-card-last-name").val(result.data.last_name);
                        $("#custom-card-email").val(result.data.email);
                        $("#custom-card-occupation").val(
                            result.data.occupation
                        );
                        $("#custom-card-location").val(result.data.location);
                        $("#prefix_code").val(result.data.region_code);
                        $("#phoneNumber").val(result.data.phone);
                        $("#custom-card-website").val(result.data.website);
                        updateCard(result.data);
                    }
                },
                error: function (result) {
                    displayErrorMessage(result.responseJSON.message);
                },
            });
        }
    });

    $(
        "#custom-card-first-name, #custom-card-last-name, #custom-card-email, #custom-card-occupation, #custom-card-location, .phone, #custom-card-website, #vcard_size"
    ).on("input", function () {
        updateCard($(this));
    });

    function updateCard(element) {
        let firstName = $("#custom-card-first-name").val();
        let lastName = $("#custom-card-last-name").val();
        let email = $("#custom-card-email").val();
        let occupation = $("#custom-card-occupation").val();
        let location = $("#custom-card-location").val();
        let phone = $("#phoneNumber").val();
        let website = $("#custom-card-website").val();
        let vcardSize = $("#vcard_size").val();

        if ($(element).attr("id") === "phoneNumber" || phone.length > 0) {
            let obj = {
                id: "phone_icon",
                text: '<svg viewBox="0 0 20 20"><path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg>',
                top: parseInt(vcardSize) === 1 ? 200 : 340,
                left: parseInt(vcardSize) === 1 ? 50 : 50,
            };
            if (isObjectWithIdExists(frontcanvas, obj.id) == null) {
                addSvgIcon(
                    frontcanvas,
                    obj.text,
                    obj.left,
                    obj.top,
                    0.04,
                    obj.id
                );
            }
        }
        if ($(element).attr("id") === "custom-card-email" || email.length > 0) {
            let obj = {
                id: "email_icon",
                text: '<svg viewBox="0 0 512 512"><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg>',
                top: parseInt(vcardSize) === 1 ? 240 : 300,
                left: parseInt(vcardSize) === 1 ? 50 : 50,
            };
            if (isObjectWithIdExists(frontcanvas, obj.id) == null) {
                addSvgIcon(
                    frontcanvas,
                    obj.text,
                    obj.left,
                    obj.top,
                    0.04,
                    obj.id
                );
            }
        }
        if (
            $(element).attr("id") === "custom-card-location" ||
            location.length > 0
        ) {
            let obj = {
                id: "location_icon",
                text: '<svg viewBox="0 0 384 512"><path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>',
                top: parseInt(vcardSize) === 1 ? 200 : 380,
                left: parseInt(vcardSize) === 1 ? 280 : 50,
            };
            if (isObjectWithIdExists(frontcanvas, obj.id) == null) {
                addSvgIcon(
                    frontcanvas,
                    obj.text,
                    obj.left,
                    obj.top,
                    0.04,
                    obj.id
                );
            }
        }
        if (
            $(element).attr("id") === "custom-card-website" ||
            website.length > 0
        ) {
            let obj = {
                id: "website_icon",
                text: '<svg viewBox="0 0 512 512"><path d="M352 256c0 22.2-1.2 43.6-3.3 64H163.3c-2.2-20.4-3.3-41.8-3.3-64s1.2-43.6 3.3-64H348.7c2.2 20.4 3.3 41.8 3.3 64zm28.8-64H503.9c5.3 20.5 8.1 41.9 8.1 64s-2.8 43.5-8.1 64H380.8c2.1-20.6 3.2-42 3.2-64s-1.1-43.4-3.2-64zm112.6-32H376.7c-10-63.9-29.8-117.4-55.3-151.6c78.3 20.7 142 77.5 171.9 151.6zm-149.1 0H167.7c6.1-36.4 15.5-68.6 27-94.7c10.5-23.6 22.2-40.7 33.5-51.5C239.4 3.2 248.7 0 256 0s16.6 3.2 27.8 13.8c11.3 10.8 23 27.9 33.5 51.5c11.6 26 20.9 58.2 27 94.7zm-209 0H18.6C48.6 85.9 112.2 29.1 190.6 8.4C165.1 42.6 145.3 96.1 135.3 160zM8.1 192H131.2c-2.1 20.6-3.2 42-3.2 64s1.1 43.4 3.2 64H8.1C2.8 299.5 0 278.1 0 256s2.8-43.5 8.1-64zM194.7 446.6c-11.6-26-20.9-58.2-27-94.6H344.3c-6.1 36.4-15.5 68.6-27 94.6c-10.5 23.6-22.2 40.7-33.5 51.5C272.6 508.8 263.3 512 256 512s-16.6-3.2-27.8-13.8c-11.3-10.8-23-27.9-33.5-51.5zM135.3 352c10 63.9 29.8 117.4 55.3 151.6C112.2 482.9 48.6 426.1 18.6 352H135.3zm358.1 0c-30 74.1-93.6 130.9-171.9 151.6c25.5-34.2 45.2-87.7 55.3-151.6H493.4z"/></svg>',
                top: parseInt(vcardSize) === 1 ? 240 : 420,
                left: parseInt(vcardSize) === 1 ? 280 : 50,
            };
            if (isObjectWithIdExists(frontcanvas, obj.id) == null) {
                addSvgIcon(
                    frontcanvas,
                    obj.text,
                    obj.left,
                    obj.top,
                    0.04,
                    obj.id
                );
            }
        }
        if (parseInt(vcardSize) === 1) {
            if (
                isObjectWithIdExists(frontcanvas, "qrcode") == null &&
                website != ""
            ) {
                $.ajax({
                    url:
                        route("qr-code") +
                        "?link=" +
                        encodeURIComponent(website),
                    method: "GET",
                    success: function (qrCodeSvg) {
                        addSvgIcon(
                            frontcanvas,
                            qrCodeSvg,
                            350,
                            50,
                            1,
                            "qrcode"
                        );
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    },
                });
            }
        } else if (parseInt(vcardSize) === 0) {
            if (
                isObjectWithIdExists(frontcanvas, "qrcode") == null &&
                website != ""
            ) {
                $.ajax({
                    url:
                        route("qr-code") +
                        "?link=" +
                        encodeURIComponent(website),
                    method: "GET",
                    success: function (qrCodeSvg) {
                        addSvgIcon(
                            frontcanvas,
                            qrCodeSvg,
                            100,
                            25,
                            1,
                            "qrcode"
                        );
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    },
                });
            }
        }

        if (parseInt(vcardSize) === 1) {
            //Horizontal card
            var textObjects = [
                {
                    id: "name",
                    text: firstName + " " + lastName,
                    top: 55,
                    left: 45,
                    fontSize: 25,
                },
                {
                    id: "occupation",
                    text: occupation,
                    top: 100,
                    left: 50,
                    fontSize: 16,
                },
                { id: "email", text: email, top: 240, left: 90, fontSize: 14 },
                { id: "phone", text: phone, top: 200, left: 90, fontSize: 14 },
                {
                    id: "location",
                    text: location,
                    top: 200,
                    left: 310,
                    fontSize: 14,
                },
                {
                    id: "website",
                    text: website,
                    top: 240,
                    left: 310,
                    fontSize: 14,
                },
            ];
        } else if (parseInt(vcardSize) === 0) {
            //Vertical card
            var textObjects = [
                {
                    id: "name",
                    text: firstName + " " + lastName,
                    top: 150,
                    left: 50,
                    fontSize: 25,
                },
                {
                    id: "occupation",
                    text: occupation,
                    top: 240,
                    left: 80,
                    fontSize: 18,
                },
                { id: "email", text: email, top: 300, left: 90, fontSize: 14 },
                { id: "phone", text: phone, top: 340, left: 90, fontSize: 14 },
                {
                    id: "location",
                    text: location,
                    top: 380,
                    left: 90,
                    fontSize: 14,
                },
                {
                    id: "website",
                    text: website,
                    top: 420,
                    left: 90,
                    fontSize: 14,
                },
            ];
        }

        textObjects.forEach(function (obj) {
            let existingObject = null;
            frontcanvas.getObjects().forEach(function (object) {
                if (object.id === obj.id) {
                    existingObject = object;
                }
            });
            if (existingObject == null) {
                // var textboxWidth = parseInt(vcardSize) === 0 ? 170 : obj.text.length * obj.fontSize;
                var textboxWidth = parseInt(vcardSize) === 0 ? 200 : 175;
                var textAlign = parseInt(vcardSize) === 0 ? "center" : "left";
                var text = new fabric.Textbox(obj.text, {
                    left: obj.left,
                    top: obj.top,
                    fontSize: obj.fontSize,
                    fontFamily: "Arial",
                    id: obj.id,
                    width: textboxWidth,
                    whiteSpace: "pre",
                    overflow: "wrap",
                    splitByGrapheme: true,
                });
                if (parseInt(vcardSize) === 0 && obj.id === "name") {
                    text.set("textAlign", textAlign);
                }
                frontcanvas.add(text);
            } else {
                existingObject.set({
                    text: obj.text,
                    width: parseInt(vcardSize) === 0 ? 200 : 175,
                    textAlign: existingObject.id === "name" ? "center" : "left",
                });
            }
            frontcanvas.renderAll();
        });
    }

    listenSubmit("#custom-e-card-form", function (e) {
        e.preventDefault();

        if ($("#custom-e-vcard-id").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.vcard_name_required"));
            return false;
        }
        if ($("#custom-e-vcard-id").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.vcard_name_required"));
            return false;
        }

        if ($("#custom-card-first-name").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.first_name_required"));
            return false;
        }
        if ($("#custom-card-last-name").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.last_name_required"));
            return false;
        }
        let email = $("#custom-card-email").val().trim();
        if (email.length === 0) {
            displayErrorMessage(Lang.get("js.email_required"));
            return false;
        }
        let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailPattern.test(email)) {
            displayErrorMessage(Lang.get("js.invalid_email"));
            return false;
        }
        if ($("#custom-card-occupation").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.occupation_field_required"));
            return false;
        }
        if ($("#custom-card-location").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.location_field_required"));
            return false;
        }

        if ($("#phoneNumber").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.phone_number_required"));
            return false;
        }
        if ($("#custom-card-website").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.website_field_required"));
            return false;
        }
        let urlPattern = /^(https?:\/\/)?([\w-]+\.)+[\w-]+(\/[\w-]*)*$/i;
        if (
            $("#custom-card-website").val() &&
            !urlPattern.test($("#custom-card-website").val())
        ) {
            displayErrorMessage(Lang.get("js.provide_valid_wbsite_url"));
            return false;
        }
        if ($("#custom-e-card-logo").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.logo_field_required"));
            return false;
        }
        if ($("#e-card-front-image").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.front_image_field_required"));
            return false;
        }
        if ($("#e-card-back-image").val().trim().length === 0) {
            displayErrorMessage(Lang.get("js.back_image_field_required"));
            return false;
        }

        if (!$("#custom-e-card-form").find("#error-msg").hasClass("d-none")) {
            return false;
        }
        var zip = new JSZip();

        var frontDataURL = frontcanvas.toDataURL().split(";base64,")[1];
        var backDataURL = backcanvas.toDataURL().split(";base64,")[1];

        zip.file("front_canvas.png", frontDataURL, { base64: true });
        zip.file("back_canvas.png", backDataURL, { base64: true });

        zip.generateAsync({ type: "blob" })
            .then(function (content) {
                var downloadLink = document.createElement("a");
                downloadLink.href = URL.createObjectURL(content);
                downloadLink.download = "custom_e_card.zip";
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
                $("#custom-e-card-form")[0].reset();
                $("#custom-e-card-logo", "#e-card-front-image", "#e-card-back-image").val("");
                $("#custom-e-vcard-id").val("").trigger("change");
                $("#exampleInputImage, #forntImage, #backInputImage").css("background-image", 'url("/web/media/logos/infyom.png")');
                frontcanvas.clear();
                backcanvas.clear();

            })
            .catch(function (err) {
                console.error("Error generating zip file: ", err);
            });
    });
});
