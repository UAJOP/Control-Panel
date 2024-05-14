
<div class="background">
</div>


<script>
    const background = document.querySelector(".background");
    const backgroundGlass = document.querySelector(".background-glass");

    const colors = [
        "orange",
        "indianred",
        "deepskyblue",
    ]

    function setColorsInBackground() {
        for (let i = 0; i < 16; i++) {
            const color = colors[Math.floor(Math.random() * colors.length)];

            const div = document.createElement("div");
            div.style.backgroundColor = color;
            div.style.left = `${Math.random() * 100}%`;
            div.style.top = `${Math.random() * 100}%`;
            background.appendChild(div);
        }
    }

    // document.addEventListener("mousemove", (e) => {
    //
    //     const x = e.clientX / window.innerWidth;
    //     const y = e.clientY / window.innerHeight;
    //
    //     background.style.transform = `translate(-${x * 50}px, -${y * 50}px)`;
    // });

    document.addEventListener("DOMContentLoaded", () => {
        setColorsInBackground();
    });
</script>
