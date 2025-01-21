export default class PageItem {
    constructor(parent) {
        this.parent = parent;
    }

    add(data, callback) {
        // Clear existing pagination items
        while (this.parent.firstChild) {
            this.parent.removeChild(this.parent.firstChild);
        }
        
        if (!data || !data.links || !Array.isArray(data.links)) {
            return;
        }
    
        data.links.forEach(link => {
            const li = document.createElement('li');
            li.classList.add('page-item');
            
            if (link.active) {
                li.classList.add('active');
            }
    
            const a = document.createElement('a');
            a.classList.add('page-link');
            a.innerHTML = link.label;
            a.href = '#';
    
            if (link.url) {
                a.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (callback) {
                        callback(link.url);
                    }
                });
            }
            
            li.appendChild(a);
            this.parent.appendChild(li);
        });
    }
}