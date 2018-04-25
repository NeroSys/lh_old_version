import {Option} from './option';

export class OptionGroup {
    public option_name: string;
    public option_id: number;
    public product_option_id: number;
    public type: string;
    public status: boolean;
    public values: Option[];
}
