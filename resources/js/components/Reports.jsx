import React, { useState, useEffect } from 'react';
import { BarChart, Bar, LineChart, Line, PieChart, Pie, Cell, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer } from 'recharts';

const COLORS = ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899'];

export default function Reports() {
    const [reportData, setReportData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [dateRange, setDateRange] = useState({
        start: new Date(new Date().getFullYear(), 0, 1).toISOString().split('T')[0],
        end: new Date().toISOString().split('T')[0]
    });
    const [activeTab, setActiveTab] = useState('overview');

    useEffect(() => {
        fetchReportData();
    }, [dateRange]);

    const fetchReportData = async () => {
        try {
            setLoading(true);
            const response = await fetch(`/admin/api/reports?start=${dateRange.start}&end=${dateRange.end}`);
            const data = await response.json();
            setReportData(data);
        } catch (error) {
            console.error('Error fetching report data:', error);
        } finally {
            setLoading(false);
        }
    };

    const formatCurrency = (value) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(value);
    };

    const exportReport = async (format) => {
        const url = `/admin/reports/export?format=${format}&start=${dateRange.start}&end=${dateRange.end}`;
        window.open(url, '_blank');
    };

    if (loading || !reportData) {
        return (
            <div className="flex items-center justify-center min-h-screen">
                <div className="text-center">
                    <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
                    <p className="mt-4 text-gray-600">Memuat data laporan...</p>
                </div>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-gray-50 p-6">
            <div className="max-w-7xl mx-auto space-y-6">
                {/* Header */}
                <div className="bg-white rounded-xl shadow-sm p-6">
                    <div className="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div>
                            <h1 className="text-3xl font-bold text-gray-900">Laporan Penyewaan & Pendapatan</h1>
                            <p className="text-gray-600 mt-1">Analisis komprehensif sistem rental motor</p>
                        </div>
                        <div className="flex flex-wrap items-center gap-3">
                            <div className="flex items-center gap-2">
                                <label className="text-sm font-medium text-gray-700">Dari:</label>
                                <input
                                    type="date"
                                    value={dateRange.start}
                                    onChange={(e) => setDateRange({ ...dateRange, start: e.target.value })}
                                    className="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                />
                            </div>
                            <div className="flex items-center gap-2">
                                <label className="text-sm font-medium text-gray-700">Sampai:</label>
                                <input
                                    type="date"
                                    value={dateRange.end}
                                    onChange={(e) => setDateRange({ ...dateRange, end: e.target.value })}
                                    className="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                />
                            </div>
                            <button
                                onClick={() => exportReport('pdf')}
                                className="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200 text-sm font-medium inline-flex items-center gap-2"
                            >
                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Export PDF
                            </button>
                            <button
                                onClick={() => exportReport('excel')}
                                className="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200 text-sm font-medium inline-flex items-center gap-2"
                            >
                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Export Excel
                            </button>
                        </div>
                    </div>
                </div>

                {/* Tabs */}
                <div className="bg-white rounded-xl shadow-sm">
                    <div className="border-b border-gray-200">
                        <nav className="flex -mb-px">
                            {[
                                { id: 'overview', label: 'Overview', icon: '📊' },
                                { id: 'rentals', label: 'Penyewaan', icon: '🏍️' },
                                { id: 'revenue', label: 'Pendapatan', icon: '💰' },
                                { id: 'motors', label: 'Motor', icon: '🔧' }
                            ].map(tab => (
                                <button
                                    key={tab.id}
                                    onClick={() => setActiveTab(tab.id)}
                                    className={`px-6 py-4 text-sm font-medium border-b-2 transition-colors ${
                                        activeTab === tab.id
                                            ? 'border-blue-600 text-blue-600'
                                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                    }`}
                                >
                                    <span className="mr-2">{tab.icon}</span>
                                    {tab.label}
                                </button>
                            ))}
                        </nav>
                    </div>

                    <div className="p-6">
                        {activeTab === 'overview' && <OverviewTab data={reportData} formatCurrency={formatCurrency} />}
                        {activeTab === 'rentals' && <RentalsTab data={reportData} formatCurrency={formatCurrency} />}
                        {activeTab === 'revenue' && <RevenueTab data={reportData} formatCurrency={formatCurrency} />}
                        {activeTab === 'motors' && <MotorsTab data={reportData} formatCurrency={formatCurrency} />}
                    </div>
                </div>
            </div>
        </div>
    );
}

function OverviewTab({ data, formatCurrency }) {
    return (
        <div className="space-y-6">
            {/* Summary Cards */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <StatCard
                    title="Total Penyewaan"
                    value={data.totalRentals}
                    icon="🏍️"
                    color="blue"
                />
                <StatCard
                    title="Penyewaan Aktif"
                    value={data.activeRentals}
                    icon="✅"
                    color="green"
                />
                <StatCard
                    title="Total Pendapatan"
                    value={formatCurrency(data.totalRevenue)}
                    icon="💰"
                    color="yellow"
                />
                <StatCard
                    title="Total Motor"
                    value={data.totalMotors}
                    icon="🔧"
                    color="purple"
                />
            </div>

            {/* Monthly Trend Chart */}
            <div className="bg-white rounded-lg border border-gray-200 p-6">
                <h3 className="text-lg font-semibold text-gray-900 mb-4">Tren Penyewaan & Pendapatan Bulanan</h3>
                <ResponsiveContainer width="100%" height={300}>
                    <LineChart data={data.monthlyStats}>
                        <CartesianGrid strokeDasharray="3 3" />
                        <XAxis dataKey="month_name" />
                        <YAxis yAxisId="left" />
                        <YAxis yAxisId="right" orientation="right" />
                        <Tooltip formatter={(value, name) => name === 'revenue' ? formatCurrency(value) : value} />
                        <Legend />
                        <Line yAxisId="left" type="monotone" dataKey="rentals" stroke="#3b82f6" name="Penyewaan" strokeWidth={2} />
                        <Line yAxisId="right" type="monotone" dataKey="revenue" stroke="#10b981" name="Pendapatan" strokeWidth={2} />
                    </LineChart>
                </ResponsiveContainer>
            </div>

            {/* Revenue Distribution */}
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div className="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 className="text-lg font-semibold text-gray-900 mb-4">Distribusi Pendapatan</h3>
                    <ResponsiveContainer width="100%" height={250}>
                        <PieChart>
                            <Pie
                                data={[
                                    { name: 'Admin (30%)', value: data.adminRevenue },
                                    { name: 'Pemilik (70%)', value: data.ownerRevenue }
                                ]}
                                cx="50%"
                                cy="50%"
                                labelLine={false}
                                label={({ name, percent }) => `${name}: ${(percent * 100).toFixed(0)}%`}
                                outerRadius={80}
                                fill="#8884d8"
                                dataKey="value"
                            >
                                {[0, 1].map((index) => (
                                    <Cell key={`cell-${index}`} fill={COLORS[index]} />
                                ))}
                            </Pie>
                            <Tooltip formatter={(value) => formatCurrency(value)} />
                        </PieChart>
                    </ResponsiveContainer>
                    <div className="mt-4 space-y-2">
                        <div className="flex justify-between text-sm">
                            <span className="text-gray-600">Pendapatan Admin:</span>
                            <span className="font-semibold text-green-600">{formatCurrency(data.adminRevenue)}</span>
                        </div>
                        <div className="flex justify-between text-sm">
                            <span className="text-gray-600">Pendapatan Pemilik:</span>
                            <span className="font-semibold text-blue-600">{formatCurrency(data.ownerRevenue)}</span>
                        </div>
                    </div>
                </div>

                <div className="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 className="text-lg font-semibold text-gray-900 mb-4">Status Motor</h3>
                    <ResponsiveContainer width="100%" height={250}>
                        <PieChart>
                            <Pie
                                data={Object.entries(data.motorsByStatus).map(([key, value]) => ({
                                    name: key.charAt(0).toUpperCase() + key.slice(1),
                                    value: value
                                }))}
                                cx="50%"
                                cy="50%"
                                labelLine={false}
                                label={({ name, value }) => `${name}: ${value}`}
                                outerRadius={80}
                                fill="#8884d8"
                                dataKey="value"
                            >
                                {Object.keys(data.motorsByStatus).map((_, index) => (
                                    <Cell key={`cell-${index}`} fill={COLORS[index + 2]} />
                                ))}
                            </Pie>
                            <Tooltip />
                        </PieChart>
                    </ResponsiveContainer>
                </div>
            </div>
        </div>
    );
}

function RentalsTab({ data, formatCurrency }) {
    return (
        <div className="space-y-6">
            {/* Rental Stats */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                <StatCard
                    title="Total Penyewaan"
                    value={data.totalRentals}
                    icon="📋"
                    color="blue"
                />
                <StatCard
                    title="Sedang Aktif"
                    value={data.activeRentals}
                    icon="🚀"
                    color="green"
                />
                <StatCard
                    title="Selesai"
                    value={data.completedRentals}
                    icon="✅"
                    color="purple"
                />
            </div>

            {/* Rentals by Package */}
            <div className="bg-white rounded-lg border border-gray-200 p-6">
                <h3 className="text-lg font-semibold text-gray-900 mb-4">Penyewaan Berdasarkan Paket</h3>
                <ResponsiveContainer width="100%" height={300}>
                    <BarChart data={Object.entries(data.rentalsByPackage).map(([key, value]) => ({
                        name: key.charAt(0).toUpperCase() + key.slice(1),
                        value: value
                    }))}>
                        <CartesianGrid strokeDasharray="3 3" />
                        <XAxis dataKey="name" />
                        <YAxis />
                        <Tooltip />
                        <Legend />
                        <Bar dataKey="value" fill="#3b82f6" name="Jumlah Penyewaan" />
                    </BarChart>
                </ResponsiveContainer>
            </div>

            {/* Recent Rentals */}
            <div className="bg-white rounded-lg border border-gray-200 p-6">
                <h3 className="text-lg font-semibold text-gray-900 mb-4">Transaksi Terbaru</h3>
                <div className="overflow-x-auto">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50">
                            <tr>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motor</th>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penyewa</th>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Durasi</th>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody className="bg-white divide-y divide-gray-200">
                            {data.recentTransactions.map((rental) => (
                                <tr key={rental.id} className="hover:bg-gray-50">
                                    <td className="px-4 py-3 text-sm text-gray-900">#{rental.id}</td>
                                    <td className="px-4 py-3 text-sm text-gray-900">{rental.motor}</td>
                                    <td className="px-4 py-3 text-sm text-gray-900">{rental.penyewa}</td>
                                    <td className="px-4 py-3 text-sm text-gray-600">{rental.durasi}</td>
                                    <td className="px-4 py-3 text-sm font-semibold text-gray-900">{formatCurrency(rental.total)}</td>
                                    <td className="px-4 py-3">
                                        <span className={`px-2 py-1 text-xs font-semibold rounded-full ${
                                            rental.status === 'active' ? 'bg-green-100 text-green-700' :
                                            rental.status === 'completed' ? 'bg-blue-100 text-blue-700' :
                                            'bg-yellow-100 text-yellow-700'
                                        }`}>
                                            {rental.status}
                                        </span>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}

function RevenueTab({ data, formatCurrency }) {
    return (
        <div className="space-y-6">
            {/* Revenue Stats */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                <StatCard
                    title="Total Pendapatan"
                    value={formatCurrency(data.totalRevenue)}
                    icon="💰"
                    color="green"
                />
                <StatCard
                    title="Pendapatan Admin"
                    value={formatCurrency(data.adminRevenue)}
                    icon="🏢"
                    color="blue"
                />
                <StatCard
                    title="Pendapatan Pemilik"
                    value={formatCurrency(data.ownerRevenue)}
                    icon="👥"
                    color="purple"
                />
            </div>

            {/* Monthly Revenue Chart */}
            <div className="bg-white rounded-lg border border-gray-200 p-6">
                <h3 className="text-lg font-semibold text-gray-900 mb-4">Pendapatan Bulanan</h3>
                <ResponsiveContainer width="100%" height={350}>
                    <BarChart data={data.monthlyStats}>
                        <CartesianGrid strokeDasharray="3 3" />
                        <XAxis dataKey="month_name" />
                        <YAxis />
                        <Tooltip formatter={(value) => formatCurrency(value)} />
                        <Legend />
                        <Bar dataKey="revenue" fill="#10b981" name="Pendapatan" />
                    </BarChart>
                </ResponsiveContainer>
            </div>

            {/* Top Earning Owners */}
            <div className="bg-white rounded-lg border border-gray-200 p-6">
                <h3 className="text-lg font-semibold text-gray-900 mb-4">Pemilik Motor Terbaik</h3>
                <div className="overflow-x-auto">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50">
                            <tr>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peringkat</th>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Pemilik</th>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody className="bg-white divide-y divide-gray-200">
                            {data.topEarningOwners.map((owner, index) => (
                                <tr key={owner.id} className="hover:bg-gray-50">
                                    <td className="px-4 py-3 text-sm">
                                        <span className={`inline-flex items-center justify-center w-8 h-8 rounded-full font-bold ${
                                            index === 0 ? 'bg-yellow-100 text-yellow-700' :
                                            index === 1 ? 'bg-gray-100 text-gray-700' :
                                            index === 2 ? 'bg-orange-100 text-orange-700' :
                                            'bg-blue-50 text-blue-700'
                                        }`}>
                                            {index + 1}
                                        </span>
                                    </td>
                                    <td className="px-4 py-3 text-sm font-medium text-gray-900">{owner.name}</td>
                                    <td className="px-4 py-3 text-sm font-semibold text-green-600">{formatCurrency(owner.total_earnings)}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}

function MotorsTab({ data, formatCurrency }) {
    return (
        <div className="space-y-6">
            {/* Motor Stats */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                <StatCard
                    title="Total Motor"
                    value={data.totalMotors}
                    icon="🏍️"
                    color="blue"
                />
                <StatCard
                    title="Motor Tersedia"
                    value={data.motorsByStatus.tersedia}
                    icon="✅"
                    color="green"
                />
                <StatCard
                    title="Motor Disewa"
                    value={data.motorsByStatus.disewa}
                    icon="🔄"
                    color="yellow"
                />
            </div>

            {/* Rentals by Motor Type */}
            <div className="bg-white rounded-lg border border-gray-200 p-6">
                <h3 className="text-lg font-semibold text-gray-900 mb-4">Penyewaan Berdasarkan Tipe CC</h3>
                <ResponsiveContainer width="100%" height={300}>
                    <BarChart data={Object.entries(data.rentalsByType).map(([key, value]) => ({
                        name: `${key} CC`,
                        value: value
                    }))}>
                        <CartesianGrid strokeDasharray="3 3" />
                        <XAxis dataKey="name" />
                        <YAxis />
                        <Tooltip />
                        <Legend />
                        <Bar dataKey="value" fill="#8b5cf6" name="Jumlah Penyewaan" />
                    </BarChart>
                </ResponsiveContainer>
            </div>

            {/* Top Performing Motors */}
            <div className="bg-white rounded-lg border border-gray-200 p-6">
                <h3 className="text-lg font-semibold text-gray-900 mb-4">Motor Terpopuler</h3>
                <div className="overflow-x-auto">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50">
                            <tr>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peringkat</th>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motor</th>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pemilik</th>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Sewa</th>
                            </tr>
                        </thead>
                        <tbody className="bg-white divide-y divide-gray-200">
                            {data.topMotors.map((motor, index) => (
                                <tr key={motor.id} className="hover:bg-gray-50">
                                    <td className="px-4 py-3 text-sm">
                                        <span className={`inline-flex items-center justify-center w-8 h-8 rounded-full font-bold ${
                                            index === 0 ? 'bg-yellow-100 text-yellow-700' :
                                            index === 1 ? 'bg-gray-100 text-gray-700' :
                                            index === 2 ? 'bg-orange-100 text-orange-700' :
                                            'bg-blue-50 text-blue-700'
                                        }`}>
                                            {index + 1}
                                        </span>
                                    </td>
                                    <td className="px-4 py-3 text-sm font-medium text-gray-900">{motor.name}</td>
                                    <td className="px-4 py-3 text-sm text-gray-600">{motor.owner}</td>
                                    <td className="px-4 py-3 text-sm font-semibold text-blue-600">{motor.rental_count} kali</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}

function StatCard({ title, value, icon, color }) {
    const colorClasses = {
        blue: 'bg-blue-100 text-blue-600',
        green: 'bg-green-100 text-green-600',
        yellow: 'bg-yellow-100 text-yellow-600',
        purple: 'bg-purple-100 text-purple-600',
        red: 'bg-red-100 text-red-600'
    };

    return (
        <div className="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div className="flex items-center justify-between">
                <div>
                    <p className="text-sm font-medium text-gray-600 mb-1">{title}</p>
                    <p className="text-2xl font-bold text-gray-900">{value}</p>
                </div>
                <div className={`w-12 h-12 rounded-full flex items-center justify-center text-2xl ${colorClasses[color]}`}>
                    {icon}
                </div>
            </div>
        </div>
    );
}
