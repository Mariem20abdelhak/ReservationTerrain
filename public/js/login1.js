const reducedResponse = true;
const isReduced = !!reducedResponse ? reducedResponse : false;

console.log(isReduced);

const users = [
  { user: "norberto", pass: "1234" },
  { user: "Karen", pass: "5678" },
  { user: "Yamile", pass: "9012" },
  { user: "gaby", pass: "3456" },
  { user: "Gilberto", pass: "7890" },
];
let node = "";
let val = "";
const login = { user: "", pass: "" };

function error() {
  console.log("ERROR!!!!");
}

function logOn() {
  console.log("hola logOn");
}
function userExist() {
  $(users).each(function (i, el) {
    if (JSON.stringify(el) === JSON.stringify(login)) {
      return "hola mundo";
    }
    return false;
    // JSON.stringify(el) === JSON.stringify(login);
  });
}

$("#login").on("click", function (e) {
  e.preventDefault();
  $("input").each(function (i, el) {
    const errorMessageId =
      "#message" +
      $(el)
        .attr("id")
        .replace(/^\w/, (c) => c.toUpperCase());
    node = $(el).attr("id");
    val = $(el).val();
    !val ? $(errorMessageId).show() : $(errorMessageId).hide();
    login["name" === node ? "user" : node] = val;
  });
  console.log(userExist());
});

const encuestas = {
  test: {
    001: {
      id: 001,
      p: "¿de que color es el cielo?",
      r: ["azul", "verde", "amarillo"],
    },
    002: {
      id: 002,
      p: "¿cuanto es 2 + 2?",
      r: ["tres", "cuatro", "cinco", "no se"],
    },
    003: {
      id: 003,
      p: "¿vamos a ir a echar cheves?",
      r: ["si", "no"],
    },
    004: {
      id: 004,
      p: "¿crees que llueva hoy?",
      r: ["si", "no", "tal vez"],
    },
    005: {
      id: 005,
      p: "¿terminaremos la app para el cinco de agosto?",
      r: ["si, definitivamente", "No creeeo"],
    },
  },
};

const respuestas = {
  test: {
    001: {
      azul: 123,
      verde: 456,
      amarillo: 1,
    },
  },
};
