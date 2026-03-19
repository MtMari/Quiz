import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["collectionContainer"];

    static values = {
        index       : Number,
        prototype   : String,
    };

    connect(){
        document.querySelectorAll('div#domanda_rispostas > fieldset')
            .forEach((element) =>{
                this.addEliminaRispostaButton(element);
            });
        console.log(document.querySelectorAll('div#domanda_rispostas > div'))
    }
    
    addEliminaRispostaButton(item)
    {
        const button = document.createElement('button');
        button.innerText = 'Elimina Risposta';
        button.className = 'btn btn-outline-danger mb-3';

        item.appendChild(button);

        // aggiungi evento al bottone: prevent default e remove()
        button.addEventListener('click', (e) => 
        {
            e.preventDefault();
            item.remove();
        });
    }

    addCollectionElement(event)
    {
        // crea un elemento li
        const item = document.createElement('li');

        // replace il prototypeValue con: replace(/__name__/g, this.indexValue)
        item.innerHTML = this.prototypeValue.replace(/__name__/g, this.indexValue);
        // appendi il child
        this.collectionContainerTarget.appendChild(item);
        console.log(this.collectionContainerTarget);

        // index ++
        this.indexValue++;
        
        this.addEliminaRispostaButton(item);
    }
}