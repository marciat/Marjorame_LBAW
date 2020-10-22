function showMore() {
    let moreText = document.getElementById("show_more");
    let btnText = document.getElementById("show_more_btn");
    if (moreText.style.display === "none" || moreText.style.display === "") {
        btnText.innerHTML = "SHOW LESS";
        moreText.style.display = "inline";
    } else {
        btnText.innerHTML = "SHOW MORE";
        moreText.style.display = "none";
    }
  } 