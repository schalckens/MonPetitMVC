function chercheUn() {
    if (document.getElementById("id").value == "-- Choisir --"){
        doucment.getElementById("retour").styme.visibility = "hidden";
    } else {
        var xhr = new XMLHttpRequest()
        var response;
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('retour').innerHTML = xhr.responseText;
                document.getElementById("retour").style.visibility="visible";
            }
        }
        xhr.open("post","/?c=gestionClient&a=chercheUnAjax",true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        parametres = "id=" + document.getElementById("id").value;
        xhr.send(parametres);
    }
}

var chIdClient = document.getElementById("id");
chIdClient.addEventListener('change', chercheUn, false);