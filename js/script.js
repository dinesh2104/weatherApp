const wrapper = document.querySelector(".wrapper"),
inputPart = document.querySelector(".input-part"),
infoTxt = inputPart.querySelector(".info-txt"),
inputField = inputPart.querySelector("input"),
locationBtn = inputPart.querySelector("button"),
weatherPart = wrapper.querySelector(".weather-part"),
wIcon = weatherPart.querySelector("img"),
arrowBack = wrapper.querySelector("header i");

let api;

inputField.addEventListener("keyup", e =>{
    if(e.key == "Enter" && inputField.value != ""){
        requestApi(inputField.value);
    }
});

locationBtn.addEventListener("click", () =>{
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(onSuccess, onError);
    }else{
        alert("Your browser not support geolocation api");
    }
});

function requestApi(city){
    api = `https://api.weatherapi.com/v1/current.json?q=${city}&key=495908698d71426eadc124522231106`;
    fetchData();
}

function onSuccess(position){
    const {latitude, longitude} = position.coords;
    api = `https://api.weatherapi.com/v1/current.json?q=${latitude},${longitude}&key=495908698d71426eadc124522231106`;
    fetchData();
}

function onError(error){
    infoTxt.innerText = error.message;
    infoTxt.classList.add("error");
}

function fetchData(){
    infoTxt.innerText = "Getting weather details...";
    infoTxt.classList.add("pending");
    fetch(api).then(res => res.json()).then(result => weatherDetails(result)).catch(() =>{
        infoTxt.innerText = "Something went wrong";
        infoTxt.classList.replace("pending", "error");
    });
}

function weatherDetails(info){
    console.log(info);
    
    if(info.error!=undefined && info.error.code == "1006"){
        infoTxt.classList.replace("pending", "error");
        infoTxt.innerText = `${inputField.value} isn't a valid city name`;
    }else{
        console.log("inside");
        const city = info.location.name;
        const country = info.location.country;
        const description = info.current.condition.text;
        const temp=info.current.temp_c; 
        const feels_like=info.current.feelslike_c;
        const humidity = info.current.humidity;

        wIcon.src=info.current.condition.icon;
        // if(id == 800){
        //     wIcon.src = "icons/clear.svg";
        // }else if(id >= 200 && id <= 232){
        //     wIcon.src = "icons/storm.svg";  
        // }else if(id >= 600 && id <= 622){
        //     wIcon.src = "icons/snow.svg";
        // }else if(id >= 701 && id <= 781){
        //     wIcon.src = "icons/haze.svg";
        // }else if(id >= 801 && id <= 804){
        //     wIcon.src = "icons/cloud.svg";
        // }else if((id >= 500 && id <= 531) || (id >= 300 && id <= 321)){
        //     wIcon.src = "icons/rain.svg";
        // }

        console.log(humidity);
        
        weatherPart.querySelector(".temp .numb").innerText = Math.floor(temp);
        weatherPart.querySelector(".weather").innerText = description;
        weatherPart.querySelector(".location span").innerText = `${city}, ${country}`;
        weatherPart.querySelector(".temp .numb-2").innerText = Math.floor(feels_like);
        weatherPart.querySelector(".humidity span").innerText = `${humidity}%`;
        infoTxt.classList.remove("pending", "error");
        infoTxt.innerText = "";
        inputField.value = "";
        wrapper.classList.add("active");
    }
}

arrowBack.addEventListener("click", ()=>{
    wrapper.classList.remove("active");
});


