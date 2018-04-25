import {Variant} from './variant';
import {Option} from "./option";

export class VariantCollection {
    private data: Variant[];
    private basePrice: number;

    public setData(data):void {
        this.data = data;
    }

    public getAll(): Variant[] {
        return this.data;
    }

    public getActiveItems(): Variant[] {
        return this.data.filter(variant => variant.status === true)
    }

    public getCountItems(): number {
        return this.getAll().length;
    }

    public getCountActiveItems(): number {
        return this.getActiveItems().length;
    }

    public getBasePrice(): number {
        this.data.forEach(
            variant => {
                this.basePrice = (this.basePrice === undefined || variant.price < this.basePrice) ? variant.price : this.basePrice;
            }
        )
        return this.basePrice;
    }

    public setAvailableVariants(data: Option): void {
        this.data.forEach(
            (variant, index) => {
                this.data[index].status = this.data[index].options.find(option => option.option_value_id === data.option_value_id) ? true : false;
            }
        )
    }
}
