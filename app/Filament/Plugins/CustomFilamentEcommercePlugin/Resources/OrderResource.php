<?php

namespace App\Filament\Plugins\CustomFilamentEcommercePlugin\Resources;

use App\Models\Account;
use Filament\Tables\Table;
use TomatoPHP\FilamentEcommerce\Filament\Resources\OrderResource as BaseOrderResource;
use TomatoPHP\FilamentTypes\Models\Type;
use Filament\Tables\Actions\ExportAction;
use TomatoPHP\FilamentEcommerce\Filament\Export\ExportOrders;
use Filament\Tables;
use Filament\Forms;
use Filament\Notifications\Notification;
use TomatoPHP\FilamentAccounts\Components\AccountColumn;
use TomatoPHP\FilamentEcommerce\Models\Branch;
use TomatoPHP\FilamentEcommerce\Models\Company;
use TomatoPHP\FilamentTypes\Components\TypeColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use TomatoPHP\FilamentEcommerce\Models\Delivery;
use TomatoPHP\FilamentLocations\Models\City;
use TomatoPHP\FilamentLocations\Models\Country;
use TomatoPHP\FilamentEcommerce\Models\OrderLog;
use TomatoPHP\FilamentEcommerce\Models\Product;
use TomatoPHP\FilamentEcommerce\Models\ShippingPrice;
use TomatoPHP\FilamentEcommerce\Models\ShippingVendor;

class OrderResource extends BaseOrderResource
{
    public static function table(Table $table): Table
    {
        $types = Type::query()
            ->where('for', 'orders')
            ->where('type', 'status');

        return $table
            ->headerActions([
                ExportAction::make()
                    ->hiddenLabel()
                    ->tooltip(trans('filament-ecommerce::messages.orders.actions.export'))
                    ->color('success')
                    ->icon('heroicon-s-document-arrow-down')
                    ->exporter(ExportOrders::class),
                Tables\Actions\Action::make('import')
                    ->hiddenLabel()
                    ->tooltip(trans('filament-ecommerce::messages.orders.actions.import'))
                    ->color('warning')
                    ->form([
                        Forms\Components\Textarea::make('data')
                            ->default("name: \nphone: \naddress: \nsource: \nitems: SKU*QTY,SKU*QTY")
                            ->hint(trans('filament-ecommerce::messages.orders.import.hint'))
                            ->label(trans('filament-ecommerce::messages.orders.import.order_text'))
                            ->autosize()
                            ->required()
                    ])
                    ->action(function (array $data) {
                        $getMultiOrders = explode("====", $data['data']);
                        if (count($getMultiOrders)) {
                            foreach ($getMultiOrders as $orderItem) {
                                (new self)->convertTextToOrder($orderItem);
                            }
                        } else {
                            (new self)->convertTextToOrder($data['data']);
                        }
                    })
                    ->icon('heroicon-s-document-text')
            ])
            ->columns([
                AccountColumn::make('account.id')
                    ->label(trans('filament-ecommerce::messages.orders.columns.account_id'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(trans('filament-ecommerce::messages.orders.columns.created_at'))
                    ->description(fn($record) => $record->created_at->diffForHumans())
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('uuid')
                    ->label(trans('filament-ecommerce::messages.orders.columns.uuid'))
                    ->description(fn($record) => $record->type . ' by ' . $record->user?->name)
                    ->label('UUID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TypeColumn::make('status')
                    ->label(trans('filament-ecommerce::messages.orders.columns.status'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('filament-ecommerce::messages.orders.columns.name'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->description(fn($record) => $record->phone)
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(trans('filament-ecommerce::messages.orders.columns.phone'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label(trans('filament-ecommerce::messages.orders.columns.address'))
                    ->description(fn($record) => $record->country->name . ', ' . $record->city->name . ', ' . $record->area->name . ', ' . $record->flat)
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('shipper.name')
                    ->label(trans('filament-ecommerce::messages.orders.columns.shipper_id'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('branch.name')
                    ->label(trans('filament-ecommerce::messages.orders.columns.branch_id'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TypeColumn::make('payment_method')
                    ->label(trans('filament-ecommerce::messages.orders.columns.payment_method'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TypeColumn::make('source')
                    ->label(trans('filament-ecommerce::messages.orders.columns.source'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('shipping')
                    ->label(trans('filament-ecommerce::messages.orders.columns.shipping'))
                    ->summarize(Tables\Columns\Summarizers\Sum::make()->money(locale: 'en', currency: setting('site_currency')))
                    ->money(locale: 'en', currency: setting('site_currency'))
                    ->color('warning')
                    ->sortable(),
                Tables\Columns\TextColumn::make('vat')
                    ->label(trans('filament-ecommerce::messages.orders.columns.vat'))
                    ->summarize(Tables\Columns\Summarizers\Sum::make()->money(locale: 'en', currency: setting('site_currency')))
                    ->money(locale: 'en', currency: setting('site_currency'))
                    ->color('warning')
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount')
                    ->label(trans('filament-ecommerce::messages.orders.columns.discount'))
                    ->summarize(Tables\Columns\Summarizers\Sum::make()->money(locale: 'en', currency: setting('site_currency')))
                    ->money(locale: 'en', currency: setting('site_currency'))
                    ->color('danger')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label(trans('filament-ecommerce::messages.orders.columns.total'))
                    ->summarize(Tables\Columns\Summarizers\Sum::make()->money(locale: 'en', currency: setting('site_currency')))
                    ->money(locale: 'en', currency: setting('site_currency'))
                    ->color('success')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_approved')
                    ->label(trans('filament-ecommerce::messages.orders.columns.is_approved'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ToggleColumn::make('is_closed')
                    ->label(trans('filament-ecommerce::messages.orders.columns.is_closed'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(trans('filament-ecommerce::messages.orders.columns.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->groups([
                Tables\Grouping\Group::make('status')
            ])
            ->filtersLayout(Tables\Enums\FiltersLayout::Modal)
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(trans('filament-ecommerce::messages.orders.filters.status'))
                    ->searchable()
                    ->options((clone $types)->pluck('name', 'key')->toArray()),
                Tables\Filters\Filter::make('company')
                    ->label(trans('filament-ecommerce::messages.orders.filters.company'))
                    ->form([
                        Forms\Components\Select::make('company_id')
                            ->label(trans('filament-ecommerce::messages.orders.filters.company'))
                            ->searchable()
                            ->options(Company::query()->pluck('name', 'id')->toArray())
                            ->live(),
                        Forms\Components\Select::make('branch_id')
                            ->searchable()
                            ->options(fn(Forms\Get $get) => Branch::query()->where('company_id', $get('company_id'))->pluck('name', 'id')->toArray())
                            ->label(trans('filament-ecommerce::messages.orders.filters.branch_id')),
                    ])
                    ->query(
                        fn(Builder $query, array $data) => $query
                            ->when($data['company_id'], fn(Builder $query, $company_id) => $query->where('company_id', $company_id))
                            ->when($data['branch_id'], fn(Builder $query, $branch_id) => $query->where('branch_id', $branch_id))
                    ),
                Tables\Filters\Filter::make('location')
                    ->label(trans('filament-ecommerce::messages.orders.filters.location'))
                    ->form([
                        Forms\Components\Select::make('country_id')
                            ->label(trans('filament-ecommerce::messages.orders.filters.country_id'))
                            ->searchable()
                            ->options(Country::query()->pluck('name', 'id')->toArray())
                            ->live(),
                        Forms\Components\Select::make('city_id')
                            ->label(trans('filament-ecommerce::messages.orders.filters.city_id'))
                            ->searchable()
                            ->options(fn(Forms\Get $get) => City::where('country_id', $get('country_id'))->pluck('name', 'id')->toArray()),
                        Forms\Components\Select::make('area_id')
                            ->label(trans('filament-ecommerce::messages.orders.filters.area_id'))
                            ->searchable()
                            ->options(fn(Forms\Get $get) => \TomatoPHP\FilamentLocations\Models\Area::where('city_id', $get('city_id'))->pluck('name', 'id')->toArray()),
                    ])
                    ->query(
                        fn(Builder $query, array $data) => $query
                            ->when($data['country_id'], fn(Builder $query, $country_id) => $query->where('country_id', $country_id))
                            ->when($data['city_id'], fn(Builder $query, $city_id) => $query->where('city_id', $city_id))
                            ->when($data['area_id'], fn(Builder $query, $area_id) => $query->where('area_id', $area_id))
                    ),
                Tables\Filters\SelectFilter::make('account_id')
                    ->label(trans('filament-ecommerce::messages.orders.filters.account_id'))
                    ->searchable()
                    ->options(Account::pluck('name', 'id')->toArray()),
                // Tables\Filters\SelectFilter::make('user_id')
                //     ->label(trans('filament-ecommerce::messages.orders.filters.user_id'))
                //     ->searchable()
                //     ->options(User::pluck('name', 'id')->toArray()),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label(trans('filament-ecommerce::messages.orders.filters.payment_method'))
                    ->searchable()
                    ->options([
                        'cash' => 'Cash',
                        'credit' => 'Credit',
                        'wallet' => 'Wallet',
                    ]),
                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label(trans('filament-ecommerce::messages.orders.filters.is_approved')),
                Tables\Filters\TernaryFilter::make('is_closed')
                    ->label(trans('filament-ecommerce::messages.orders.filters.is_closed')),
            ])
            ->actions([
                Tables\Actions\Action::make('approved')
                    ->hidden(fn($record) => $record->status !== 'pending')
                    ->requiresConfirmation()
                    ->action(function ($record, array $data) {
                        $record->update(['is_approved' => 1, 'status' => 'prepared']);

                        $orderLog = new OrderLog();
                        $orderLog->user_id = Auth::user()->id;
                        $orderLog->order_id = $record->id;
                        $orderLog->status = $record->status;
                        $orderLog->is_closed = 1;
                        $orderLog->note = 'Order has been Approved by: ' . Auth::user()->name . ' and Total: ' . number_format($record->total, 2);
                        $orderLog->save();

                        Notification::make()
                            ->title('Order Approved Changed')
                            ->body('Order has been Approved')
                            ->success()
                            ->send();
                    })
                    ->label(trans('filament-ecommerce::messages.orders.actions.approved'))
                    ->tooltip(trans('filament-ecommerce::messages.orders.actions.approved'))
                    ->icon('heroicon-s-check-circle')
                    ->color('success')
                    ->iconButton(),
                Tables\Actions\Action::make('shipping')
                    ->hidden(fn($record) => $record->status === 'prepared' || $record->status === 'pending')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\Select::make('shipping_vendor_id')
                            ->label(trans('filament-ecommerce::messages.orders.columns.shipping_vendor_id'))
                            ->searchable()
                            ->live()
                            ->options(ShippingVendor::pluck('name', 'id')->toArray())
                            ->required(),
                        Forms\Components\Select::make('shipper_id')
                            ->label(trans('filament-ecommerce::messages.orders.columns.shipper_id'))
                            ->searchable()
                            ->options(fn(Forms\Get $get) => Delivery::query()->where('shipping_vendor_id', $get('shipping_vendor_id'))->pluck('name', 'id')->toArray())
                            ->required(),
                    ])
                    ->fillForm(fn($record) => [
                        'shipping_vendor_id' => $record->shipping_vendor_id,
                        'shipper_id' => $record->shipper_id,
                    ])
                    ->action(function ($record, array $data) {
                        $shippingPrice = 0;
                        $getShippingVendorPrices = ShippingPrice::query()
                            ->where('shipping_vendor_id', $data['shipping_vendor_id'])
                            ->where('country_id', $record->country_id)
                            ->where('city_id', $record->city_id)
                            ->where('area_id', $record->area_id)
                            ->where('delivery_id', $data['shipper_id'])
                            ->orWhereNull('delivery_id')
                            ->first();

                        if ($getShippingVendorPrices) {
                            $shippingPrice = $getShippingVendorPrices->price;
                        } else {
                            $shippingPrice = ShippingVendor::find($data['shipping_vendor_id'])?->price;
                        }

                        $record->update([
                            'shipping_vendor_id' => $data['shipping_vendor_id'],
                            'shipper_id' => $data['shipper_id'],
                            'status' => 'shipped',
                            'shipping' => $shippingPrice,
                            'total' => $record->ordersItems()->sum('total') + $shippingPrice,
                        ]);

                        $orderLog = new OrderLog();
                        $orderLog->user_id = Auth::user()->id;
                        $orderLog->order_id = $record->id;
                        $orderLog->status = $record->status;
                        $orderLog->is_closed = 1;
                        $orderLog->note = 'Order Shipper has been selected: ' . $record->delivery?->name . ' by: ' . Auth::user()->name . ' and Total: ' . number_format($record->total, 2);
                        $orderLog->save();

                        Notification::make()
                            ->title('Order Shipper Changed')
                            ->body('Order Shipper has been selected: ' . $record->delivery?->name)
                            ->success()
                            ->send();
                    })
                    ->label(trans('filament-ecommerce::messages.orders.actions.shipping'))
                    ->tooltip(trans('filament-ecommerce::messages.orders.actions.shipping'))
                    ->icon('heroicon-s-truck')
                    ->color('danger')
                    ->iconButton(),
                Tables\Actions\Action::make('status')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->label(trans('filament-ecommerce::messages.orders.columns.status'))
                            ->searchable()
                            ->options((clone $types)->pluck('name', 'key')->toArray())
                            ->required()
                            ->default('pending'),
                    ])
                    ->fillForm(fn($record) => [
                        'status' => $record->status,
                    ])
                    ->action(function ($record, array $data) {
                        $record->update(['status' => $data['status']]);

                        $orderLog = new OrderLog();
                        $orderLog->user_id = Auth::user()->id;
                        $orderLog->order_id = $record->id;
                        $orderLog->status = $record->status;
                        $orderLog->is_closed = 1;
                        $orderLog->note = 'Order update by ' . Auth::user()->name . ' and Total: ' . number_format($record->total, 2);
                        $orderLog->save();

                        Notification::make()
                            ->title('Order Status Changed')
                            ->body('Order status has been changed to ' . $data['status'])
                            ->success()
                            ->send();
                    })
                    ->tooltip(trans('filament-ecommerce::messages.orders.actions.status'))
                    ->label(trans('filament-ecommerce::messages.orders.actions.status'))
                    ->icon('heroicon-s-adjustments-horizontal')
                    ->color('warning')
                    ->iconButton(),
                Tables\Actions\Action::make('print')
                    ->tooltip(trans('filament-ecommerce::messages.orders.actions.print'))
                    ->icon('heroicon-s-printer')
                    ->url(fn($record) => route('order.print', $record->id))
                    ->openUrlInNewTab()
                    ->iconButton(),
                Tables\Actions\ViewAction::make()
                    ->tooltip(trans('filament-ecommerce::messages.orders.actions.show'))
                    ->iconButton(),
                Tables\Actions\EditAction::make()
                    ->tooltip(trans('filament-ecommerce::messages.orders.actions.edit'))
                    ->iconButton(),
            ])
            ->defaultSort('created_at', 'desc')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
