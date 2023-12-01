function fizzBuzzMessage(number) {
    let message = "";

    if (number % 11 === 0) {
        message += "Surprise";
    } else {
        if (number % 3 === 0) {
            message += "Fizz";
        }
        if (number % 5 === 0) {
            message += "Buzz";
        }
    }

    if (message === "") {
        message = number;
    }

    return message;
}

function runFizzBuzz() {
    const upperLimit = document.getElementById("upperLimit").value;
    let result = "";

    for (let i = 1; i <= upperLimit; i++) {
        result += fizzBuzzMessage(i) + "<br>";
    }

    document.getElementById("result").innerHTML = result;
}