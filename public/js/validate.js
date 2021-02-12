document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.js_validate').forEach(el=> {
        el.addEventListener('keyup', validate)})
})

function validate(){
    if(!this.value){

    }

    if(this.classList.contains('js_numbers')) {
        const regex = /^(\d)?(\d)?(\d?)$/i

        const regex3 = /^(0)?(\.)?(\d{1})?$/i

        const regex2 = /^(\d{1})(\.)?(\d{1})?(\d{1})?(\d{1})?(\d{1})?$/i


//        if(!regex3.test(this.value))

        // if(regex3.test(this.value)) {
        //     console.log('222')
        //     this.value = ''
        // }


        // if(regex.test(this.value)) {
        //     console.log('444')
        //     this.value = this.value.replace(/^(\d)?(\d)?(\d)?$/i, '0.$1$2$3')
        // }
        // else if(regex2.test(this.value)) {
        //     console.log('rt')
        //     this.value = this.value.replace(regex2, '$3.$4$5$6')
        // }
        // else if(regex3.test(this.value))  this.value = ''

    }
        // if(!onlyNumbers(this.value))
        //     showError('.onlyNubmers', this);

}

function onlyNumbers(val){
    const regex = /[\d|\.]/gm;
    if (!regex.test(val)) {
        return false
    }
}

function showError(type, element) {
    let gg = element.parentElement.querySelector('.onlyNubmers').classList.remove('hide')

}
