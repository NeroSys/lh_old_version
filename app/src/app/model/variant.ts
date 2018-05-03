import {Option} from './option';
import {Availability} from "./availability";

export class Variant {
    id: number;
    product_option_id: number;
    number: string;
    status: boolean;
    price: number;
    price_old: number;
    availability: Availability[];
    options: Option[];
}
