let URL = window.location.href;

const createDocument = document.getElementById("create-document");
const nameDocument   = document.getElementById("name-document");
const quantityData   = document.getElementById("quantity-data");
var a = document.getElementById('download-file');


createDocument.addEventListener("click", (e) => {
    e.preventDefault();

    async function fetchingWrite(data) {
        console.log(data);
        try {
          const response = await fetch(`${URL}/fetchingWrite`, {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
          });

          const result = await response.json();
          console.log("Success:", result);
          if (result.status === 201) {
            alert("Listo");
            a.href = "";
            a.href = result.DownloadLink;
            a.style.display = 'block';
          }
        } catch (error) {
          console.error("Error:", error);
        }
      }
      const data = { nameFiles:nameDocument.value, contentType:"text/plain", contentDisposition:"attachement", quantity:quantityData.value, };
      console.log(data);
      fetchingWrite(data);

});