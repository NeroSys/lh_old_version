import {Component, OnInit} from '@angular/core';
import {MainService} from './app.service';
import {VariantCollection} from './model/variant-collection';
import {FormFields} from './model/form-fields';
import {OptionGroup} from './model/option-group';

declare var product_id: any;

@Component({
    selector: 'app-product-options',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
    public price: number;
    public caption: string = '';
    public massage: string = '';
    public selectedData = {};

    private form: FormFields;
    public variants: VariantCollection;
    private selectedOptions = {};


    constructor(private mainService: MainService) {
        this.form = new FormFields();
        this.variants = new VariantCollection();
    }

    ngOnInit(): void {
        this.mainService
            .getSpecifications(product_id)
            .then(
                variants => this.variants.setData(variants)
            ).then(
            e => {
                this.price = this.variants.getBasePrice();
                this.form.setData(this.variants);
            }
        );
    }

    public select(): void {
        this.setChoice();
    }

    private setChoice(): void {
        this.setSelectedOptions();
        this.setCaption();
    }

    private setSelectedOptions(): void {
        this.form.fields.forEach(variant => {
            if (this.selectedData[variant.option_id]) {
                const option = variant.values.find(item => (item.option_value_id === this.selectedData[variant.option_id]));
                this.selectedOptions[variant.option_id] = option;
                this.variants.setAvailableVariants(option);
            }
        });
    }

    private setCaption(): void {
        this.caption = '';
        this.massage = '';

        this.form.fields.forEach(variant => {
            const option = variant.values.find(item => (item.option_value_id === this.selectedData[variant.option_id]));
            console.log(option);
            if (option !== undefined) {
                this.caption += this.caption.length > 0 ? '; ' : '';
                this.caption += variant.option_name + ': ' + option.option_value_name;
            } else {
                this.massage += this.massage.length > 0 ? '; ' : '';
                this.massage += 'Поле "' + variant.option_name + '" обязательно для заполнения. ';
            }
        });
    }

    public onSubmit(): void {
        // if (this.form.valid) {
        //     const request = {};
        //     request['quantity'] = this.form.controls.quantity.value;
        //     request['product_id'] = product_id;
        //     request['option'] = [];
		//
        //     let body = 'quantity=' + this.form.controls.quantity.value;
        //     body += '&product_id=' + product_id;
		//
        //     this.optionGroups.forEach(
        //         variant => {
        //             const selectedOption = this.selectedOptions[variant.option_id];
        //             if (selectedOption) {
        //                 console.log(selectedOption);
        //                 request['option'][selectedOption.product_option_id] = selectedOption.option_value_id;
        //                 body += '&option[' + selectedOption.product_option_id + ']=' + selectedOption.option_value_id;
        //             }
        //         }
        //     );
        //     console.log('request: ', request);
        //     this.mainService.addToCart(body);
        // }
    }

    // private setOptionGroup(variants: VariantCollection): void {
    //     this.variants.forEach(variant => {
    //         variant.options.forEach(
    //             option => {
    //                 this.setOptionItem(option);
    //                 this.setFormControl(option);
    //             }
    //         );
    //     });
    // }




    // private setVariantsStatus(): void {
    //     this.variants.forEach(
    //         variant => {
    //             variant.options.forEach(
    //                 (option, index) => {
    //                     if (
    //                         this.selectedOptions[option.option_id]
    //                         && this.selectedOptions[option.option_id] !== null
    //                         && this.selectedOptions[option.option_id] !== option
    //                     ) {
    //                         variant.status = false;
    //                         option.status = false;
    //                     }
    //                 }
    //             );
    //         }
    //     );
    //     this.setOptionGroup();
    // }

}
