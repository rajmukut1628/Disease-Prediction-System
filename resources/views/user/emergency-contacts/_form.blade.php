<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="dps-label" for="name">CONTACT NAME</label>
        <input id="name"
               name="name"
               type="text"
               value="{{ old('name', $emergencyContact->name ?? '') }}"
               class="dps-input mt-2"
               required
               placeholder="Example: Samia Akter">
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <label class="dps-label" for="relation">RELATION</label>
        <input id="relation"
               name="relation"
               type="text"
               value="{{ old('relation', $emergencyContact->relation ?? '') }}"
               class="dps-input mt-2"
               placeholder="Example: Mother, Father, Brother, Doctor">
        <x-input-error :messages="$errors->get('relation')" class="mt-2" />
    </div>

    <div>
        <label class="dps-label" for="phone">PHONE NUMBER</label>
        <input id="phone"
               name="phone"
               type="text"
               value="{{ old('phone', $emergencyContact->phone ?? '') }}"
               class="dps-input mt-2"
               required
               placeholder="+8801XXXXXXXXX">
        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
    </div>

    <div>
        <label class="dps-label" for="email">EMAIL ADDRESS</label>
        <input id="email"
               name="email"
               type="email"
               value="{{ old('email', $emergencyContact->email ?? '') }}"
               class="dps-input mt-2"
               placeholder="example@email.com">
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>
</div>

<div class="mt-6 grid md:grid-cols-3 gap-4">
    <label class="dps-soft rounded-3xl p-5 cursor-pointer block">
        <div class="flex items-center gap-3">
            <input type="checkbox"
                   name="is_primary"
                   value="1"
                   class="rounded border-slate-600 bg-slate-900 text-rose-500 focus:ring-rose-500"
                   @checked(old('is_primary', $emergencyContact->is_primary ?? false))>

            <div>
                <p class="text-white font-black">Primary Contact</p>
                <p class="mt-1 text-xs text-slate-400">
                    Main emergency person
                </p>
            </div>
        </div>
    </label>

    <label class="dps-soft rounded-3xl p-5 cursor-pointer block">
        <div class="flex items-center gap-3">
            <input type="checkbox"
                   name="notify_by_sms"
                   value="1"
                   class="rounded border-slate-600 bg-slate-900 text-rose-500 focus:ring-rose-500"
                   @checked(old('notify_by_sms', $emergencyContact->notify_by_sms ?? true))>

            <div>
                <p class="text-white font-black">SMS Alert</p>
                <p class="mt-1 text-xs text-slate-400">
                    Phone alert ready
                </p>
            </div>
        </div>
    </label>

    <label class="dps-soft rounded-3xl p-5 cursor-pointer block">
        <div class="flex items-center gap-3">
            <input type="checkbox"
                   name="notify_by_email"
                   value="1"
                   class="rounded border-slate-600 bg-slate-900 text-rose-500 focus:ring-rose-500"
                   @checked(old('notify_by_email', $emergencyContact->notify_by_email ?? false))>

            <div>
                <p class="text-white font-black">Email Alert</p>
                <p class="mt-1 text-xs text-slate-400">
                    Email alert ready
                </p>
            </div>
        </div>
    </label>
</div>

<div class="mt-6 rounded-3xl bg-rose-500/10 border border-rose-300/20 p-5">
    <p class="text-rose-100 font-black">Emergency Alert Note</p>
    <p class="mt-2 text-sm text-rose-100/80">
        এই contact গুলো high-risk AI result, emergency symptom, critical report, বা severe health insight হলে alert-ready system-এ ব্যবহার করা হবে।
    </p>
</div>