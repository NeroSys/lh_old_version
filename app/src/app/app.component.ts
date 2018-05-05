import {Component, OnInit} from '@angular/core';
import {MainService} from './app.service';
import {VariantCollection} from './model/variant-collection';
import {OptionGroup} from './model/option-group';
import {Option} from "./model/option";
import {Variant} from "./model/variant";
import {Alert} from "./model/alert";
import {Marker} from "./model/marker";
import {NgbModal} from '@ng-bootstrap/ng-bootstrap';

import {} from '@types/googlemaps';

declare var product_id: any;

@Component({
    selector: 'app-product-options',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
    public price: number = null;
    public oldPrice: number = null;
    public alerts: Alert[] = [];
    public selectedData = {quantity: 1};
    public selectedVariant: Variant;
    public marker: Marker;
    public fields: OptionGroup[] = [];
    private variants: VariantCollection;

    positions = [];


    constructor(private mainService: MainService, private modalService: NgbModal) {
        this.variants = new VariantCollection();
        this.marker = new Marker;
    }

    public ngOnInit(): void {
        this.mainService
            .getSpecifications(product_id)
            .then(
                variants => this.variants.setData(variants)
            ).then(
            e => {
                this.setData(this.variants);
                this.setDefaultValues();
            }
        );
    }

    public select(optionId: number): void {
        this.setChoice();
        this.setOptionsStatus(optionId);
    }

    public onSubmit(): void {
        let query = this.prepareRequestAddToCart();
        let alert = new Alert();
        this.mainService.addToCart(query).then(
            response => {
                if(response.error !== undefined){
                    alert.type = 'error';
                    alert.message = response.error;
                } else if (response.success !== undefined){
                    alert.type = 'success';
                    alert.message = response.success;
                }
                this.setAlert(alert);
            }
        )
    }

    public open(content) {
        this.modalService.open(content, { size: 'lg' }).result.then((result) => {

        }, (reason) => {

        });
    }


    private setChoice(): void {
        this.setSelectedOptions();
        this.setCaption();
    }

    private setSelectedOptions(): void {
        let data: any = [];
        this.fields.forEach(variant => {
            if (this.selectedData[variant.option_id]) {
                const option = variant.values.find(item => (item.option_value_id === this.selectedData[variant.option_id]));
                this.variants.setAvailableVariants(option);
                data.push(option);
            }
        });
        this.selectedVariant = this.variants.findBy(data);
        if(this.selectedVariant === undefined){
            this.selectedVariant = this.variants.getFirstBy(data[0]);
            this.selectedVariant.options.forEach(option => {
                this.selectedData[option.option_id] = option.option_value_id
            })

        }
        this.setPrice();
    }

    private setPrice():void {
        this.oldPrice = this.selectedVariant.price_old;
        this.price = this.selectedVariant.price;
    }

    private setCaption(): void {
        let caption = '';
        this.fields.forEach(field => {
            let option = field.values.find(item => (item.option_value_id === this.selectedData[field.option_id]));
            if (option !== undefined) {
                caption +=  caption.length > 0 ? '; ' : '';
                caption += field.option_name + ': ' + option.option_value_name;
            }
        });
    }

    private setData(variants: VariantCollection):void {
        variants.getAll().forEach(variant => {
            variant.options.forEach(
                option => {
                    this.setOptionItem(option);
                }
            );

        });
    }

    private setOptionItem(option: Option): void {
        let group_index = this.fields.findIndex(item => option.option_id === item.option_id);
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

    private setDefaultValues(): void {
        this.variants.getFirst().options.forEach(option => {
            this.selectedData[option.option_id] = option.option_value_id;
        });

        this.setChoice();
        this.setOptionsStatus(this.selectedVariant.options[0].option_id);
    }

    private setOptionsStatus(optionId: number): void {
        let itsAfterSelectedOption: boolean = false;
        let queryData: Option[] = [];

        this.selectedVariant.options.forEach(option => {

            if(itsAfterSelectedOption){
                this.setOptionsStatusForNextFields(option.option_id, queryData);
            } else {
                queryData.push(option);
            }

            if (option.option_id === optionId){
                itsAfterSelectedOption = true;
            }

        });
    }

    private setOptionsStatusForNextFields(option_id, query: Option[]){
        let findBy: Option[];

        this.fields.forEach((field, fi) => {
            if (field.option_id !== option_id)
                return false;

            field.values.forEach((option, fiv) => {
                findBy  = Object.assign([], query);
                findBy.push(option);
                this.fields[fi].values[fiv].status = this.variants.findBy(findBy) === undefined ? false : true;
            });
        });
    }

    private prepareRequestAddToCart(): string {
        let request = {};
        request['quantity'] = this.selectedData['quantity'];
        request['product_id'] = product_id;
        request['option'] = [];

        let body = 'quantity=' + this.selectedData['quantity'];
        body += '&product_id=' + product_id;

        this.selectedVariant.options.forEach(
            option => {
                request['option'][option.product_option_id] = option.option_value_id;
                body += '&option[' + option.product_option_id + ']=' + option.option_value_id;

            }
        );
        return body;
    }

    private setAlert(alert: Alert){
        let index = this.alerts.findIndex(find => find.type === alert.type);
        if(index < 0){
            this.alerts.push(alert);
        } else {
            this.alerts[index] = alert;
        }
    }

    public showInfoWindow({target: marker}){

    }



}
