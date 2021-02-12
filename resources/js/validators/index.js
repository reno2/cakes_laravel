import { extend } from 'vee-validate';

import {
    ext,
    size,
    length,
} from 'vee-validate/dist/rules';

extend('ext', {
    ...ext,
    message: 'Не допустимый формат файлов'
});

extend('size', {
    ...size,
    message: 'Не верный размер файла'
});



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







extend('check_count', {
    validate: (value, { compare }) => {
        return date_compare({value, compare, validationType: 'check_count'});
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
