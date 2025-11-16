<style>
    #btt {
        display: none; /* Hidden by default */
        position: fixed; /* Fixed/sticky position */
        bottom: 10px; /* Place the button at the bottom of the page */
        right: 0px; /* Place the button 30px from the right */
        z-index: 99; /* Make sure it does not overlap */
        border: none; /* Remove borders */
        outline: none; /* Remove outline */
        background-color: #032e59; /* Set a background color */
        color: white; /* Text color */
        cursor: pointer; /* Add a mouse pointer on hover */
        padding: 10px; /* Some padding */
        border-top-left-radius: 10px; /* Rounded corners */
        border-bottom-left-radius: 10px; /* Rounded corners */
        font-size: 15px; /* Increase font size */
        opacity: 100%;
    }

    #btt:hover {
        background-color: #555; /* Add a dark-grey background on hover */
    }
</style>

<!-- Back to top button -->
<button onclick="topFunction()" class="noprint" id="btt" wire:ignore>
    &nbsp;&nbsp;<i class="fas fa-arrow-up">&nbsp;&nbsp;</i>
</button>

<script>
    // Get the button:
    let mybutton = document.getElementById("btt");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    }
</script>