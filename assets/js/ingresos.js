$(document).ready(() => {
  $("#calendar").on("change", () => {
    $("#cally1").html($("#calendar").val());
  });
});
