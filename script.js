function updateClock(){

    const now = new Date();

    document.getElementById("clock").innerHTML =
        now.toLocaleTimeString();

}

setInterval(updateClock,1000);

updateClock();

const chart = document.getElementById("salesChart");

if(chart){

new Chart(chart,{

type:"bar",

data:{

labels:[
"Jan","Feb","Mar","Apr","May","Jun",
"Jul","Aug","Sep","Oct","Nov","Dec"
],

datasets:[{

label:"Monthly Sales",

data:monthlySales,

borderWidth:1

}]

},

options:{

responsive:true,

scales:{

y:{
beginAtZero:true
}

}

}

});

}
// ====================== LIVE SEARCH ======================

const search = document.getElementById("search");

if (search) {

    search.addEventListener("keyup", function () {

        let keyword = this.value;

        if (keyword.length === 0) {
            document.getElementById("searchResult").innerHTML = "";
            return;
        }

        fetch("php/php/search.php?search=" + encodeURIComponent(keyword))
            .then(res => res.text())
            .then(data => {
                document.getElementById("searchResult").innerHTML = data;
            });

    });

}