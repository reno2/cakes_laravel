import { extend } from 'vee-validate';

import {
    ext,
   size
} from 'vee-validate/dist/rules';

import date_compare from './rules/file_rules';

// extend('email', {
//     ...email,
//     message: 'You should add a valid email address'
// });
//
// extend('ext', {
//     ...ext,
//     message: 'Не допустимое расширение'
// });

extend('size', {
    ...size,
    message: 'Не верный размер файла'
});





extend('is_earlier', {
    validate: (value, { compare }) => {
        return date_compare({value, compare, validationType: 'earlier'});
    },
    params: ['compare', 'dateType'],
    message: 'Максимальное колчество файлов 5 {dateType}'
});


// extend('is_beyond', {
//     validate: (value, { compare }) => {
//         return date_compare({value, compare, validationType: 'beyond'});
//     },
//     params: ['compare', 'dateType'],
//     message: 'The selected date must not be older than {dateType}'
// });
