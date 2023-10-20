<a onclick="topFunction()" href="#" id="back2Top" title="Вернуться к началу" {{ $attributes->merge(['class' => 'hidden fixed bottom-1 right-1']) }}><svg class="h-8 w-8 text-gray-500 border border-gray-400 hover:border-sky-800 rounded hover:bg-gray-200 hover:text-sky-800"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="6 15 12 9 18 15" /></svg></a>

<script>
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 150 || document.documentElement.scrollTop > 150) {
        document.getElementById("back2Top").style.display = "block";
    } else {
        document.getElementById("back2Top").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}
</script>