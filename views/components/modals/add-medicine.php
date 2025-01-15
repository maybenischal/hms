<div id="addMedicineModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Add Medicine Schedule</h3>
            <form action="/index.php?route=add-medicine-schedule" method="POST" class="mt-4">
                <input type="hidden" name="patient_id" value="<?= $patientId ?>">
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="medicine_id">
                        Select Medicine
                    </label>
                    <select name="medicine_id" id="medicine_id" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Select a medicine</option>
                        <?php foreach ($medicines as $medicine): ?>
                            <option value="<?= $medicine['id'] ?>"><?= htmlspecialchars($medicine['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="dosage">
                        Dosage
                    </label>
                    <input type="text" name="dosage" id="dosage" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="frequency">
                        Frequency
                    </label>
                    <input type="text" name="frequency" id="frequency" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="start_date">
                        Start Date
                    </label>
                    <input type="date" name="start_date" id="start_date" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="end_date">
                        End Date
                    </label>
                    <input type="date" name="end_date" id="end_date"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="hideModal('addMedicine')"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Add Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> 