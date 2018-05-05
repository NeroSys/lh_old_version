import {Availability} from "./availability";

export class Option {
    id: number;
    price_base: number;
    price_discount: number;
    price_discount_type: string;
    quantity: number;
    product_id: number;
    id_erp: string;
    price: number;
    option_id: number;
    option_name: string;
    type: string;
    sort_order: number;
    option_value_id: number;
    option_value_name: string;
    price_prefix: string;
    subtract: number;
    points: number;
    points_prefix: string;
    weight: number;
    weight_prefix: string;
    product_option_group: number;
    product_option_id: number;
    status: boolean;
}
