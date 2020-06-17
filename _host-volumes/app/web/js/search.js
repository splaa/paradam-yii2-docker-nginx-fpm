$(document).ready(function(){
	$('#search').on('input', async function(){
		let response = await fetch('/api/search?q=' + $(this).val());

		if (response.ok) {
			let html = await response.text();
			$('#list_search').html(html);
		} else {
			console.log("PARADAM.ME:" + response.status);
		}
	});
})