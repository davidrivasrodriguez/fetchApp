export default class PageItem {
    constructor(parent, currentPage) {
        this.parent = parent;
        this.currentPage = currentPage;
    }

    add(link, callBack) {
        const li = document.createElement("li");
        li.classList.add("page-item");
        
        let tag;

        if (!link.url) {
            li.classList.add("disabled");
        }

        if (link.active) {
            li.classList.add("active");
        }
        if(link.label != '...') {
            tag = document.createElement("a");
        } else {
            tag = document.createElement("span");
        }



        tag.classList.add("page-link");
        if (link.url) {
            tag.dataset.url = link.url;
        }

        if(link.label == '&laquo; Previous') {
            link.label = '<';
        } else if(link.label == 'Next &raquo;') {
            link.label = '>';
        }

        const textNode = document.createTextNode(link.label);

        tag.appendChild(textNode);
        li.appendChild(tag);
        this.parent.appendChild(li);
        
        if (link.url) {
            tag.addEventListener('click', (event) => {
                console.log(event.target.dataset.url);
                callBack();
            });
        }
    }
}