import {Variant} from './variant';
import {Option} from "./option";

export class VariantCollection {
    private data: Variant[] = [];

    public setData(data):void {
        this.data = data;
    }

    public getAll(): Variant[] {
        return this.data;
    }

    public getFirst(): Variant {
        return this.data[0];
    }

    public getFirstBy(option: Option): Variant {
        return this.data.filter(variant => {
            return variant.options.find(
                option_variant => option_variant.option_value_name === option.option_value_name
            )
        })[0];
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

    public setAvailableVariants(data: Option): void {
        this.data.forEach(
            (variant, index) => {
                this.data[index].status = this.data[index].options.find(option => option.option_value_id === data.option_value_id) ? true : false;
            }
        )
    }

    public findBy(options: Option[]): Variant {
        let variants = this.data;
        options.forEach(
            option => {
                variants = variants.filter(
                    variant => {
                        return variant.options.find(
                            option_variant => option_variant.option_value_name === option.option_value_name
                        )
                    }
                )
            }
        )
        return variants[0];
    }
}
