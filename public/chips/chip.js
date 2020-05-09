document.addEventListener('DOMContentLoaded', function () {

    ///////////////////////////////////////////inputChip//////////////////////////////////////////////
    let instances;
    let instance;
    let elems;
    let inputHidden = document.getElementById('post_tags');

    elems = document.querySelector('.chips');
    instances = M.Chips.init(elems, {});
    instance = M.Chips.getInstance(elems);

    let chipsList = [];

    let inputChip = elems.firstElementChild;
    const onInputChip = (el) => {

        chipsList = [];
        console.log(el.keyCode);
        if (el.keyCode == 13 || el.keyCode == 8) {

            let chips = document.querySelectorAll('.chip');

            chips.forEach(chip => {

                chipsList.push(chip.textContent.replace('close', ''));

                chip.firstElementChild.addEventListener('click', (close) => {
                    updateDom(close.target.parentElement.textContent.replace('close', ''));
                })
            })
            console.log(chipsList);
            inputHidden.value = chipsList.join(',');
        }

    }
    inputChip.addEventListener('keyup', onInputChip)

    function updateDom(element) {
        chipsList = chipsList.filter(el => el !== element);
        inputHidden.value = chipsList.join(',');
    }

    function populatChipList() {
        let chips = document.querySelectorAll('.chip');

        chips.forEach(chip => {

            chipsList.push(chip.textContent.replace('close', ''));

            // chip.firstElementChild.addEventListener('click',(close)=>{
            //    updateDom(close.target.parentElement.textContent.replace('close',''));})
        })
        console.log(chipsList);
        inputHidden.value = chipsList.join(',');
    }

    ///////////////////////autocomplete/////////////////////////////////////////////
    var ev = new KeyboardEvent('keydown', {
        altKey: false,
        bubbles: true,
        cancelBubble: false,
        cancelable: true,
        charCode: 0,
        code: "Enter",
        composed: true,
        ctrlKey: false,
        currentTarget: null,
        defaultPrevented: true,
        detail: 0,
        eventPhase: 0,
        isComposing: false,
        isTrusted: true,
        key: "Enter",
        keyCode: 13,
        location: 0,
        metaKey: false,
        repeat: false,
        returnValue: false,
        shiftKey: false,
        type: "keydown",
        which: 13
    });

    //txtbox.dispatchEvent(ev);

    const fetchTags = (string) => {
       // const route = "{{ path('blog_show', {slug: 'my-blog-post'})|escape('js') }}";
        let urlTags = "{{ path('tag_search',{text:'string'}) }}";
        urlTags = urlTags.replace('string', string);
         console.log(urlTags);
         
        const resultData =axios.get(urlTags).then((response) => {
            return response.data;
        }).catch((err) => {
            console.log(err);
        });
        return resultData;
    }



    let root = document.querySelector('.collection');


    //<div class="chip" tabindex="0">g<i class="material-icons close">close</i></div>
    const debounce = (callback, delay = 1000) => {
        let timeoutId;

        return (...args) => {

            if (timeoutId) {
                clearTimeout(timeoutId);
            }
            timeoutId = setTimeout(() => {
                callback.apply(null, args);
            }, delay);

        }
    }
    async function simulateAsyncEvent(el) {
        return await el.dispatchEvent(ev);
    }
    const onSelect = (e) => {
        // console.log(e.target.textContent.trim());
        // let div=document.createElement('div');
        //     div.setAttribute('tabindex','0');
        //     div.classList.add('chip');
        //     div.innerHTML=`
        //        ${e.target.textContent.trim()}<i class="material-icons close">close</i>
        //     `; 
        //     elems.insertAdjacentHTML("afterbegin",`
        //       <div class="chip" tabindex="0" >${e.target.textContent.trim()}<i class="material-icons close">close</i></div>
        //        `); 
        elems.querySelector('input').value = '';
        elems.querySelector('input').value = e.target.textContent.trim();

        //elems.querySelector('input').dispatchEvent(ev);
        simulateAsyncEvent(elems.querySelector('input')).then(() => {
            populatChipList()
            root.classList.add('hide');
        })


        //inputChip.value
    }

    const onInputTag = async (el) => {

        let items = await fetchTags(el.target.value);
        if (!items?.length) {
            root.classList.add('hide')
            return;
        }

        root.classList.remove('hide')
        root.innerHTML = "";
        for (const item of items) {
            let a = document.createElement('a');
            a.innerHTML = `
           ${item.name}
          `;
            a.classList.add('collection-item');
            a.addEventListener('click', onSelect)
            root.appendChild(a);

        }


    }
    inputChip.addEventListener('input', debounce(onInputTag))


});