import {OptionGroup} from "./option-group";
import {VariantCollection} from "./variant-collection";
import {Option} from "./option";

export class FormFields {
    public fields: OptionGroup[] = [];
    private form: any;

    constructor() {
    }

    public setData(variants: VariantCollection):void {
        variants.getAll().forEach(variant => {
            variant.options.forEach(
                option => {
                    this.setOptionItem(option);
                }
            );
        });
    }

    public getData(): void {
        return this.form;
    }

    private setOptionItem(option: Option): void {

        const group_index = this.fields.findIndex(item => option.option_id === item.option_id);
        if (group_index < 0) {
            this.fields.push({
                option_id: option.option_id,
                option_name: option.option_name,
                product_option_id: option.product_option_id,
                type: option.type,
                status: true,
                values: [option]
            });
        } else {
            if (!this.fields[group_index].values.find(item => item.option_value_id === option.option_value_id)) {
                this.fields[group_index].values.push(option);
            }
        }
    }

}