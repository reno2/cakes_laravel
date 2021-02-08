export default ({ value, compare, validationType }) => {
    let pass  = true;

    if(value.length > Number(compare))
        pass = false

    console.log(value.length, compare, validationType)



    return pass;
}
