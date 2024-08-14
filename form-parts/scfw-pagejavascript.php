<?php
defined( 'ABSPATH' ) || exit;
?>

<script>
    function validateContactFormFields() {
        let requiredFields = document.querySelectorAll('.scfw-required');
        let requiredNotice = document.getElementById("scfw_error_notice");
        let requiredFieldsFilled = true;

        for(let field of requiredFields) {
            fieldInput = field.getElementsByTagName("input")[0];
            if (fieldInput === undefined) {
                fieldInput = field.getElementsByTagName("textarea")[0];
            }
            
            if(fieldInput.value.trim() === "") {
                field.classList.add("scfw-required-error");
                requiredFieldsFilled = false;
                requiredNotice.style.display = "block";
            } else {
                field.classList.remove("scfw-required-error");
            }
        }

        if(requiredFieldsFilled) {
            saveFormInputs();
            document.getElementById("scfw-submit-actual").click();
        }
    }

    function saveFormInputs() {
        let formInputs = document.querySelectorAll('.scfw-field input, .scfw-field textarea');
        let formValues = {};

        for(let input of formInputs) {
            if(input.name !== 'visitor_images' && input.name !== 'visitor_url' && input.name !== 'visitor_option') {
                formValues[input.name] = input.value;
            }
        }

        localStorage.setItem('scfw_form_values', JSON.stringify(formValues));
    }

    // On page load, count the number of scfw-fields, and if the number is odd, add a class to the last one to make it full width.
    document.addEventListener('DOMContentLoaded', function() {
        let scfwFields = Array.from(document.querySelectorAll('.scfw-field:not(.scfw-antispam):not(.scfw-message)'));
        let scfwFieldsLength = scfwFields.length;

        // Sort fields based on the flex order class
        scfwFields.sort((a, b) => {
            let orderA = parseInt(a.className.match(/flex-order-(\d+)/)[1]);
            let orderB = parseInt(b.className.match(/flex-order-(\d+)/)[1]);
            return orderA - orderB;
        });

        // If the number of fields is odd, add a class to the last field
        if (scfwFieldsLength % 2 !== 0) {
            scfwFields[scfwFieldsLength - 1].classList.add('scfw-odd-field');
        }
    });
</script>
<?php