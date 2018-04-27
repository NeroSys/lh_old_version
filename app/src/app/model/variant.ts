import {Option} from './option';

export class Variant {
    id: number;
    product_option_id: number;
    number: string;
    status: boolean;
    price: number;
    price_old: number;
    options: Option[];
}
