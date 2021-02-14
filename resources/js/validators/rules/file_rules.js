export default ({ value, files, validationType }) => {
    let pass  = true;

    // if(value.length > Number(compare))
    //     pass = false


    //console.log(files.files)

    for (let key in value){
      if(files.files.includes(value[key].name))
        pass = false
    }


    return pass;
}
