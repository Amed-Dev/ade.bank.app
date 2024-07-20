
class ImageAbbr extends HTMLElement {
  constructor() {
    super();
    const shadow = this.attachShadow({ mode: "open" });
    const imagen = this.getAttribute("img");
    const nombre = this.getAttribute("text");

    shadow.innerHTML = this.getStyles();
    if (imagen) {
      shadow.innerHTML += `<img src="assets/${imagen}" alt="${nombre}" />`;
    } else {
      const inicial = nombre.charAt(0);
      shadow.innerHTML += `<span>${inicial}</span>`;
    }
  }

  getStyles() {
    const color = this.getAttribute("color") ?? "black";
    const background = this.getAttribute('background') ?? "#ababab";
    const ancho = parseInt(this.getAttribute("width")) ?? "30";

    return `
      <style>
        img, span{
          max-width: 100%;
          border-radius: 50%;
          aspect-ratio: 1;
          width: ${ancho}px
        }
        img{
          object-fit: cover;
        }

        span{
          font-size: calc( ${ancho}px * .65 );
          line-height: 1em;
          min-width: 30px;
          font-weight: 700;
          display: inline-flex;
          justify-content: center;
          align-items: center;
          background: ${background};
          color: ${color};
        }
      </style>
    `;
  }
}

customElements.define("image-abbr", ImageAbbr);

