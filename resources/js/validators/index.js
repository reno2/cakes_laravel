import { extend } from 'vee-validate';

import {
    ext,
    size,
    length,
} from 'vee-validate/dist/rules';
import if_file_exists from './rules/file_rules';


extend('ext', {
    ...ext,
    message: 'Не допустимый формат файлов'
});

extend('size', {
    ...size,
    message: 'Не верный размер файла'
});


extend('check_count', {
    validate: (value, { limit, loaded }) => {
        let pass  = true;
        if(value.length > Number(limit+loaded)) pass = false
        return pass
    },
    params: ['limit', 'loaded'],
    message: 'Максимальное колчество файлов 5'
});


extend('file_exists', {
    validate: (value,  files ) => {
        return if_file_exists({value, files, validationType: 'file_exists'});
    },
    params: ['files'],
    message: 'Файл с таким именем уже загружен'
});

// extend('check_count', {
//     validate: (value, { compare }) => {
//         let pass  = true;
//         if(value.length > Number(compare))
//             pass = false
//         return date_compare({value, compare, validationType: 'check_count'});
//     },
//     params: ['compare', 'dateType'],
//     message: 'Максимальное колчество файлов 5 {dateType}'
// });
