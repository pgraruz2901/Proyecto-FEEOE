const form = document.getElementById("formulario");
const resultados = document.getElementById("resultados");

form.addEventListener("submit", function (event) {
	event.preventDefault();
	const formData = new FormData(form);
	const min = parseFloat(formData.get("min"));
	const max = parseFloat(formData.get("max"));
	const patron = formData.get("patron");

	fetch(
		`/practicas2/pedirDatos/min=${encodeURIComponent(min)}&max=${encodeURIComponent(max)}&patron=${encodeURIComponent(patron)}`,
	)
		.then((res) => res.json())
		.then((data) => {
			resultados.textContent = JSON.stringify(data, null, 2);
		})
		.catch((error) => {
			console.error("Error:", error);
		});
});