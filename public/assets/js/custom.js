/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

function datatableCallback() {
    // Delete Confirm
    jQuery("[data-delete-confirm]").each(function () {
        jQuery(this).on("click", function () {
            jQuery("#deleteModal").modal("show");

            // Get Delete URL
            const url = jQuery(this).data("delete-confirm");

            const deleteModelForm = jQuery("#deleteModelForm");
            const deleteModalInput = jQuery("#deleteModalInput");
            const deleteModalButton = jQuery("#deleteModalButton");
            const deleteModalMessage = jQuery("#deleteModalMessage");

            // Set Delete URL in Form
            deleteModelForm.attr("action", url);

            // Focus Confirm Delete Field
            setTimeout(function () {
                deleteModalInput.focus()
            }, 500);

            // Check Confirmation
            deleteModalInput.on("input", function () {
                if (deleteModalInput.val() === "") {
                    deleteModalMessage.text("CONFIRM DELETE");
                } else {
                    deleteModalMessage.text("");
                }
            });

            deleteModalButton.on("click", function () {
                if (deleteModalInput.val() === "CONFIRM DELETE") {
                    deleteModalMessage.text("");
                    deleteModalInput.val("");
                    deleteModelForm.submit();
                } else {
                    deleteModalMessage.text("CONFIRM DELETE");
                }
            });
        })
    });
}

$(document).ready(function(){
    // Select the alert and set a timeout function
    setTimeout(function () {
        $('.alert').fadeOut('slow', function() {
            $(this).alert('close');
        })

    }, 10000);
});

