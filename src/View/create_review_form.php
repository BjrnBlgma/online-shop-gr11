<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="feedback-modal">
    <h2>Оцените товар</h2>
    <form action="/add-review" method="POST">
    <div class="rating-options">
        <label for="Terrible" class="border">
            <input type="radio" id="Terrible" name="rating" value="1">
            <span class="emoji"><i class="fa-regular fa-face-sad-tear"></i></span>
            <span>Terrible</span>
            <span><h2>1</h2></span>
        </label>
        <label for="Bad" class="border">
            <input type="radio" id="Bad" name="rating" value="2">
            <span class="emoji"><i class="fa-regular fa-face-frown"></i></span>
            <span>Bad</span>
            <span><h2>2</h2></span>
        </label>
        <label for="Okay" class="border">
            <input type="radio" id="Okay" name="rating" value="3">
            <span class="emoji"><i class="fa-regular fa-face-meh"></i></span>
            <span>Okay</span>
            <span><h2>3</h2></span>
        </label>
        <label for="Good" class="border">
            <input type="radio" id="Good" name="rating" value="4" checked>
            <span class="emoji"><i class="fa-regular fa-face-smile"></i></span>
            <span>Good</span>
            <span><h2>4</h2></span>
        </label>
        <label for="Amazing" class="border">
            <input type="radio" id="Amazing" name="rating" value="5">
            <span class="emoji"><i class="fa-regular fa-face-laugh"></i></span>
            <span>Amazing!</span>
            <span><h2>5</h2></span>
        </label>
    </div>


        <input type="hidden" id="product_id" name="product_id" value="<?php echo $productId; ?>">
        <br>
    <label for="feedback-reason">Как вам товар? Поделитесь впечатлениями: опишите достоинства и недостатки</label>
    <textarea id="feedback-reason" name="review"></textarea>

    <div class="options">
        <!--<label class="checkbox">
            <input type="checkbox" id="contact-consent" checked>
            I may be contacted about this feedback. <a href="#">Privacy Policy</a>
        </label>
        <p id="contact-consent-error">Error: You must consent to be contacted.</p>

        <label class="checkbox">
            <input type="checkbox" id="join-research">
            I’d like to help improve by joining the <a href="#">Research Group</a>.
        </label>-->
    </div>
    <p id="success-message">Thank you for your feedback! Your response has been submitted.</p>
    <div class="actions">
        <button>Submit</button>
        <label style="color: red"> <?php echo $errors['warning'] ?? '';?> </label>
        <button type="button" class="btn btn-primary" onclick="window.history.back();">Cancel</button>
    </div>
    </form>

</div>

<script>
    // Get all the radio buttons
    const radioButtons = document.querySelectorAll('input[name="rating"]');
    const contactConsentCheckbox = document.getElementById("contact-consent");
    const contactConsentError = document.getElementById("contact-consent-error");
    const successMessage = document.getElementById("success-message");
    const feedbackModal = document.querySelector(".feedback-modal");

    // Function to apply styles to the selected label
    function applyStyles() {
        // Remove styles from all labels
        const labels = document.querySelectorAll(".rating-options label");
        labels.forEach((label) => {
            label.style.boxShadow = "";
            label.style.transform = "scale(1)";
            label.style.color = ""; // Remove any color changes from text
        });

        // Get the selected radio button and its associated label
        const selectedRadio = document.querySelector('input[name="rating"]:checked');
        const associatedLabel = document.querySelector(
            `label[for="${selectedRadio.id}"]`
        );

        // Apply styles to the selected label
        associatedLabel.style.boxShadow = "4px 4px 10px rgba(255, 40, 40, 0.25)";
        associatedLabel.style.transform = "scale(1.05)";
        associatedLabel.style.color = "#000"; // Change color of the text
    }

    // Attach the applyStyles function to each radio button
    radioButtons.forEach((radio) => {
        radio.addEventListener("change", applyStyles);
    });

    // Initialize the styles for the initially checked radio button
    document.addEventListener("DOMContentLoaded", applyStyles);

    // Form submission logic
    const submitButton = document.getElementById("submit");

    submitButton.addEventListener("click", function (event) {
        event.preventDefault();

        // Check if the privacy policy checkbox is checked
        if (!contactConsentCheckbox.checked) {
            contactConsentError.style.display = "block"; // Show the error message
            successMessage.style.display = "none"; // Hide the success message if there's an error
        } else {
            contactConsentError.style.display = "none"; // Hide the error message
            successMessage.style.display = "block"; // Show the success message

            // Close the modal after a short delay to show the success message
            setTimeout(function () {
                feedbackModal.style.display = "none"; // Close the modal
            }, 2000); // Close modal after 2 seconds
        }
    });

    // Cancel button logic
    const cancelButton = document.getElementById("cancel");

    cancelButton.addEventListener("click", function () {
        feedbackModal.style.display = "none"; // Close the modal
    });
</script>


<style>
    @import url("https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Poppins:wght@500&display=swap");

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: "Poppins", sans-serif;
        font-weight: 500;
        font-size: 14px;
        color: #121c51;
        background-color: #f2f6ff;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 110vh;
    }

    .feedback-modal {
        background-color: #f8faff;
        border-radius: 20px;
        padding: 70px;
        max-width: 666.22px;
        width: 100%;
        box-shadow: -80px -40px #e0e9fe;
    }

    h2 {
        font-family: "Merriweather", serif;
        font-weight: 700;
        font-size: 22px;
        margin-bottom: 20px;
    }

    p {
        font-size: 16px;
        margin-bottom: 20px;
        max-width: 421px;
        width: 100%;
    }

    .rating-options {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
    }

    .rating-options .border {
        text-align: center;
        cursor: pointer;
        border: 2px solid #e5edff;
        padding: 20px;
        border-radius: 5px;
        transition: box-shadow 0.3s, transform 0.3s;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 18%;
        min-width: 90px;
        box-sizing: border-box;
    }

    .rating-options input {
        display: none;
    }

    .rating-options .border {
        box-shadow: none;
        transform: scale(1);
        color: #60699a;
    }

    .emoji {
        display: block;
        font-size: 24px;
        margin-bottom: 4px;
        color: #60699a;
    }

    textarea {
        width: 100%;
        padding: 8px;
        margin-top: 8px;
        margin-bottom: 16px;
        border-radius: 5px;
        border: 2px solid #a3b8e8;
        resize: none;
        font-size: 1rem;
        height: 80px;
        outline: none;
    }

    input{
        width: 100%;
        padding: 8px;
        margin-top: 8px;
        margin-bottom: 16px;
        border-radius: 5px;
        border: 2px solid #a3b8e8;
        resize: none;
        font-size: 1rem;
        height: 40px;
        outline: none;
    }

    .options {
        text-align: left;
        margin-bottom: 16px;
    }

    .checkbox {
        display: block;
        margin-top: 8px;
    }

    .checkbox input {
        margin-right: 8px;
        width: 21px;
        height: 21px;
        accent-color: #ff71a4;
        cursor: pointer;
        vertical-align: middle;
    }

    .checkbox a,
    .checkbox a:visited {
        color: #d22e69;
        text-decoration: none;
    }

    .actions {
        display: flex;
        justify-content: end;
        gap: 20px;
        margin-top: 40px;
    }

    button {
        padding: 20px 30px;
        border-radius: 6px;
        border: none;
        font-size: 18px;
        cursor: pointer;
    }

    #submit {
        background-color: #ff71a4;
        color: #fff;
        font-family: "Poppins", sans-serif;
        font-weight: 500;
    }

    #cancel {
        background-color: #fff;
        color: #60699a;
    }

    #contact-consent-error {
        color: #d22e69;
        font-weight: bold;
        font-size: 14px;
        margin-top: 8px;
        display: none; /* Hide the error message by default */
    }

    #success-message {
        color: green;
        font-weight: bold;
        font-size: 14px;
        margin-top: 8px;
        display: none; /* Hide the success message by default */
    }

    @media (max-width: 720px) {
        body {
            height: auto;
        }

        .feedback-modal {
            width: 90%;
            margin: 50px auto;
        }

        .rating-options {
            flex-wrap: wrap;
            gap: 10px;
            margin: 20px auto;
            justify-content: center;
        }

        .actions {
            flex-direction: column;
        }
    }

</style>