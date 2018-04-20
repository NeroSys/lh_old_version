import {Option} from './option';

export class Specification {
    id: number;
    product_option_id: number;
    number: string;
    status: boolean;
    options: Option[];
}
