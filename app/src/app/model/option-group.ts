import {Option} from './option';

export class OptionGroup {
    option_name: string;
    option_id: number;
    product_option_id: number;
    type: string;
    status: string;
    values: Option[];
}
